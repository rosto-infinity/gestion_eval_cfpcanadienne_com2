<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\BilanCompetence;
use App\Models\Specialite;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BilanCompetenceController extends Controller
{
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

        // Si l'utilisateur a déjà un bilan pour l'année en cours
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
            DB::beginTransaction();

            $user = User::findOrFail($validated['user_id']);

            // Vérifier si un bilan existe déjà
            $exists = BilanCompetence::where('user_id', $user->id)
                ->where('annee_academique_id', $user->annee_academique_id)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', 'Un bilan existe déjà pour cet étudiant.');
            }

            $bilan = new BilanCompetence([
                'user_id' => $user->id,
                'annee_academique_id' => $user->annee_academique_id,
                'observations' => $validated['observations'] ?? null,
            ]);

            $bilan->calculateAndSave((float) $validated['moy_competences']);

            DB::commit();

            return redirect()
                ->route('bilans.show', $bilan)
                ->with('success', 'Bilan de compétences créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

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
            DB::beginTransaction();

            $bilan->observations = $validated['observations'] ?? null;
            $bilan->calculateAndSave((float) $validated['moy_competences']);

            DB::commit();

            return redirect()
                ->route('bilans.show', $bilan)
                ->with('success', 'Bilan de compétences mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

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
            DB::beginTransaction();

            $bilan->calculateAndSave($bilan->moy_competences);

            DB::commit();

            return back()->with('success', 'Bilan recalculé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

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
            DB::beginTransaction();

            $query = User::where('annee_academique_id', $validated['annee_academique_id'])
                ->whereDoesntHave('bilanCompetence', function ($q) use ($validated): void {
                    $q->where('annee_academique_id', $validated['annee_academique_id']);
                });

            if (isset($validated['specialite_id'])) {
                $query->where('specialite_id', $validated['specialite_id']);
            }

            $users = $query->get();
            $count = 0;

            foreach ($users as $user) {
                $bilan = new BilanCompetence([
                    'user_id' => $user->id,
                    'annee_academique_id' => $user->annee_academique_id,
                ]);

                $bilan->calculateAndSave((float) $validated['moy_competences_defaut']);
                $count++;
            }

            DB::commit();

            return back()->with('success', "{$count} bilans générés avec succès.");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la génération: '.$e->getMessage());
        }
    }

    public function tableauRecapitulatif(Request $request): View
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        $specialiteId = $request->input('specialite_id');

        $query = BilanCompetence::with(['user.specialite', 'anneeAcademique'])
            ->whereNotNull('moyenne_generale');

        if ($anneeId) {
            $query->where('annee_academique_id', $anneeId);
        }

        if ($specialiteId) {
            $query->whereHas('user', fn ($q) => $q->where('specialite_id', $specialiteId));
        }

        $bilans = $query->get()->sortByDesc('moyenne_generale');

        $stats = [
            'total' => $bilans->count(),
            'admis' => $bilans->filter(fn ($b) => $b->isAdmis())->count(),
            'moyenne_generale' => $bilans->avg('moyenne_generale'),
            'meilleure_moyenne' => $bilans->max('moyenne_generale'),
            'moyenne_la_plus_basse' => $bilans->min('moyenne_generale'),
        ];

        $annees = AnneeAcademique::ordered()->get();
        $specialites = Specialite::ordered()->get();

        return view('bilans.tableau-recapitulatif', compact('bilans', 'stats', 'annees', 'specialites'));
    }

    public function exportPdfTableau(Request $request)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        $specialiteId = $request->input('specialite_id');

        $query = BilanCompetence::with(['user.specialite', 'anneeAcademique'])
            ->whereNotNull('moyenne_generale');

        if ($anneeId) {
            $query->where('annee_academique_id', $anneeId);
        }

        if ($specialiteId) {
            $query->whereHas('user', fn ($q) => $q->where('specialite_id', $specialiteId));
        }

        $bilans = $query->get()->sortByDesc('moyenne_generale');

        $stats = [
            'total' => $bilans->count(),
            'admis' => $bilans->filter(fn ($b) => $b->isAdmis())->count(),
            'moyenne_generale' => $bilans->avg('moyenne_generale'),
            'meilleure_moyenne' => $bilans->max('moyenne_generale'),
            'moyenne_la_plus_basse' => $bilans->min('moyenne_generale'),
        ];

        $annee = AnneeAcademique::find($anneeId);
        $specialite = $specialiteId ? Specialite::find($specialiteId) : null;

        $pdf = Pdf::loadView('bilans.tableau-recapitulatif-pdf', compact('bilans', 'stats', 'annee', 'specialite'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'tableau_recapitulatif_'.($annee ? $annee->libelle : 'all').'_'.now()->format('Ymd').'.pdf';

        return $pdf->download($filename);
    }

    public function exportPdf(BilanCompetence $bilan)
    {
        $bilan->load(['user.specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $bilan->user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $bilan->user->getEvaluationsBySemestre(2);

        $pdf = Pdf::loadView('bilans.bilan-pdf', compact('bilan', 'evaluationsSemestre1', 'evaluationsSemestre2'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'bilan_competences_'.$bilan->user->matricule.'_'.now()->format('Ymd').'.pdf';

        return $pdf->download($filename);
    }
}
