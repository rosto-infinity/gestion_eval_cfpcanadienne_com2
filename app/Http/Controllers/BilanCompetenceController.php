<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\BilanCompetence;
use App\Models\Specialite;
use App\Models\User;
use App\Services\BilanService;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BilanCompetenceController extends Controller
{
    public function __construct(
        private BilanService $bilanService,
        private PdfService $pdfService
    ) {}

    public function index(Request $request): View
    {
        $query = BilanCompetence::with(['user.specialite', 'anneeAcademique']);

        if ($anneeId = $request->input('annee_id')) {
            $query->byAnneeAcademique((int) $anneeId);
        }

        if ($specialiteId = $request->input('specialite_id')) {
            $query->whereHas('user', fn ($q) => $q->where('specialite_id', $specialiteId));
        }

        $bilans = $query->latest()->paginate(20);
        $annees = AnneeAcademique::ordered()->get();
        $specialites = Specialite::ordered()->get();

        return view('bilans.index-bilans', compact('bilans', 'annees', 'specialites'));
    }

    public function create(Request $request)
    {
        $userId = $request->query('user_id');
        $user = $userId ? User::with(['specialite', 'anneeAcademique', 'bilanCompetence'])->findOrFail($userId) : null;

        if ($user && $user->bilanCompetence) {
            return redirect()
                ->route('bilans.edit', $user->bilanCompetence)
                ->with('info', 'Un bilan existe déjà pour cet étudiant. Vous pouvez le modifier.');
        }

        $users = User::with(['specialite', 'anneeAcademique'])
            ->whereDoesntHave('bilanCompetence')
            ->ordered()
            ->get();

        return view('bilans.create-bilans', compact('user', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'moy_competences' => 'required|numeric|min:0|max:20',
            'observations' => 'nullable|string|max:1000',
        ]);

        try {
            $user = User::findOrFail($validated['user_id']);

            $bilan = $this->bilanService->createBilan(
                $user,
                (float) $validated['moy_competences'],
                $validated['observations'] ?? null
            );

            return redirect()
                ->route('bilans.show', $bilan)
                ->with('success', 'Bilan de compétences créé avec succès.');
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(BilanCompetence $bilan): View
    {
        $bilan->load(['user.specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $bilan->user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $bilan->user->getEvaluationsBySemestre(2);

        return view('bilans.show-bilans', compact('bilan', 'evaluationsSemestre1', 'evaluationsSemestre2'));
    }

    public function edit(BilanCompetence $bilan): View
    {
        $bilan->load(['user.specialite', 'anneeAcademique']);

        return view('bilans.edit-bilans', compact('bilan'));
    }

    public function update(Request $request, BilanCompetence $bilan): RedirectResponse
    {
        $validated = $request->validate([
            'moy_competences' => 'required|numeric|min:0|max:20',
            'observations' => 'nullable|string|max:1000',
        ]);

        try {
            $this->bilanService->updateBilan(
                $bilan,
                (float) $validated['moy_competences'],
                $validated['observations'] ?? null
            );

            return redirect()
                ->route('bilans.show', $bilan)
                ->with('success', 'Bilan de compétences mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(BilanCompetence $bilan): RedirectResponse
    {
        try {
            $bilan->delete();

            return redirect()
                ->route('bilans.index')
                ->with('success', 'Bilan de compétences supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    public function recalculer(BilanCompetence $bilan): RedirectResponse
    {
        try {
            $this->bilanService->updateBilan($bilan, $bilan->moy_competences, $bilan->observations);

            return back()->with('success', 'Bilan recalculé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du recalcul: '.$e->getMessage());
        }
    }

    public function genererTous(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'specialite_id' => 'nullable|exists:specialites,id',
            'moy_competences_defaut' => 'required|numeric|min:0|max:20',
        ]);

        try {
            $count = $this->bilanService->generateBilansEnMasse(
                $validated['annee_academique_id'],
                (float) $validated['moy_competences_defaut'],
                $validated['specialite_id'] ?? null
            );

            return back()->with('success', "{$count} bilans générés avec succès.");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la génération: '.$e->getMessage());
        }
    }

    public function tableauRecapitulatif(Request $request): View
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        $specialiteId = $request->input('specialite_id');

        $bilans = $this->bilanService->getBilansWithFilters($anneeId, $specialiteId);
        $stats = $this->bilanService->calculateStatsGlobales($bilans);

        $annees = AnneeAcademique::ordered()->get();
        $specialites = Specialite::ordered()->get();

        return view('bilans.tableau-recapitulatif', compact('bilans', 'stats', 'annees', 'specialites'));
    }

    public function exportPdfTableau(Request $request)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        $specialiteId = $request->input('specialite_id');

        $bilans = $this->bilanService->getBilansWithFilters($anneeId, $specialiteId);
        $stats = $this->bilanService->calculateStatsGlobales($bilans);

        $annee = AnneeAcademique::find($anneeId);
        $specialite = $specialiteId ? Specialite::find($specialiteId) : null;

        return $this->pdfService->generateTableauRecapitulatifPdf([
            'bilans' => $bilans,
            'stats' => $stats,
            'annee' => $annee,
            'specialite' => $specialite,
        ]);
    }

    public function exportPdf(BilanCompetence $bilan)
    {
        $bilan->load(['user.specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $bilan->user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $bilan->user->getEvaluationsBySemestre(2);

        return $this->pdfService->generateBilanPdf([
            'bilan' => $bilan,
            'evaluationsSemestre1' => $evaluationsSemestre1,
            'evaluationsSemestre2' => $evaluationsSemestre2,
        ]);
    }
}
