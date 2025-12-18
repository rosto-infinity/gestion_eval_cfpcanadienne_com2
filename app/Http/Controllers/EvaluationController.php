<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationRequest;
use App\Models\AnneeAcademique;
use App\Models\Evaluation;
use App\Models\Module;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EvaluationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Evaluation::with(['user', 'module', 'anneeAcademique']);

        if ($userId = $request->input('user_id')) {
            $query->byUser((int) $userId);
        }

        if ($semestre = $request->input('semestre')) {
            $query->bySemestre((int) $semestre);
        }

        if ($anneeId = $request->input('annee_id')) {
            $query->byAnneeAcademique((int) $anneeId);
        }

        $evaluations = $query->latest()->paginate(20);

        $users = User::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.index-evaluations', compact('evaluations', 'users', 'annees'));
    }

    public function create(Request $request): View
    {
        $userId = $request->query('user_id');
        $user = $userId ? User::with(['specialite', 'anneeAcademique'])->findOrFail($userId) : null;

        // Filtrer les modules par spécialité de l'étudiant
        $modules = collect();
        if ($user && $user->specialite_id) {
            $modules = Module::where('specialite_id', $user->specialite_id)
                ->ordered()
                ->get();
        }

        $users = User::with(['specialite', 'anneeAcademique'])->ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.create-evaluations', compact('modules', 'users', 'annees', 'user'));
    }

    /**
     * -Charge les modules pour un utilisateur (AJAX).
     * ✅ -Retourne tous les modules de la spécialité
     */
    public function getUserModules(User $user): JsonResponse
    {
        $user->load(['specialite', 'anneeAcademique']);

        $modules = collect();
        if ($user->specialite_id) {
            $modules = Module::where('specialite_id', $user->specialite_id)
                ->ordered()
                ->get();
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'matricule' => $user->matricule,
                'fullName' => $user->getFullName(),
                'specialite' => $user->specialite?->intitule ?? 'N/A',
                'annee' => $user->anneeAcademique?->libelle ?? 'N/A',
                'annee_id' => $user->annee_academique_id,
            ],
            'modules' => $modules->map(fn ($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'intitule' => $m->intitule,
                'semestre' => $m->getSemestre(),
                'coefficient' => $m->coefficient,
            ]),
        ]);
    }

    /**
     * -Filtre les modules par semestre (AJAX).
     * ✅ -Nouveau endpoint pour filtrer par semestre
     */
    public function getModulesBySemestre(User $user, int $semestre): JsonResponse
    {
        $user->load('specialite');

        $modules = collect();
        if ($user->specialite_id) {
            $modules = Module::where('specialite_id', $user->specialite_id)
                ->bySemestre($semestre)
                ->ordered()
                ->get();
        }

        return response()->json([
            'modules' => $modules->map(fn ($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'intitule' => $m->intitule,
                'semestre' => $m->getSemestre(),
                'coefficient' => $m->coefficient,
            ]),
        ]);
    }

    /**
     * -Stocke une nouvelle évaluation.
     * ✅ -Utilise StoreEvaluationRequest pour la validation
     */
    public function store(StoreEvaluationRequest $request): RedirectResponse
    {
        $validated = $request->validated(); // ✅ Données validées

        try {
            // ✅ -Vérifier que le module appartient à la spécialité de l'étudiant
            $user = User::findOrFail($validated['user_id']);
            $module = Module::findOrFail($validated['module_id']);

            if ($user->specialite_id !== $module->specialite_id) {
                return back()
                    ->withInput()
                    ->with('error', '❌ Ce module n\'appartient pas à la spécialité de l\'étudiant.');
            }

            // ✅ -Vérifier si l'évaluation existe déjà
            $exists = Evaluation::where('user_id', $validated['user_id'])
                ->where('module_id', $validated['module_id'])
                ->where('semestre', $validated['semestre'])
                ->where('annee_academique_id', $validated['annee_academique_id'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', '⚠️ Cette évaluation existe déjà pour cet étudiant.');
            }

            // ✅ -Créer l'évaluation
            $evaluation = Evaluation::create($validated);

            return redirect()
                ->route('evaluations.index')
                ->with('success', "✅ Évaluation créée avec succès pour {$user->getFullName()} - {$module->code}.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()
                ->withInput()
                ->with('error', '❌ L\'étudiant ou le module n\'existe pas.');
        } catch (\Exception $e) {
            \Log::error('Erreur création évaluation:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(Evaluation $evaluation): View
    {
        $evaluation->load(['user.specialite', 'module', 'anneeAcademique']);

        return view('evaluations.show-evaluations', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation): View
    {
        $evaluation->load(['user.specialite', 'module', 'anneeAcademique']);

        // Filtrer les modules par spécialité de l'étudiant
        $modules = collect();
        if ($evaluation->user && $evaluation->user->specialite_id) {
            $modules = Module::where('specialite_id', $evaluation->user->specialite_id)
                ->ordered()
                ->get();
        }

        $users = User::with(['specialite', 'anneeAcademique'])->ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.edit-evaluations', compact('evaluation', 'modules', 'users', 'annees'));
    }

    public function update(Request $request, Evaluation $evaluation): RedirectResponse
    {
        $validated = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
        ]);

        try {
            $evaluation->update($validated);

            return redirect()
                ->route('evaluations.index')
                ->with('success', 'Évaluation mise à jour avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(Evaluation $evaluation): RedirectResponse
    {
        try {
            $evaluation->delete();

            return redirect()
                ->route('evaluations.index')
                ->with('success', 'Évaluation supprimée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    public function saisirMultiple(Request $request): View
    {
        $userId = $request->query('user_id');
        $semestre = $request->query('semestre', 1);

        $user = null;
        $modules = collect();
        $evaluations = collect();

        if ($userId) {
            $user = User::with(['specialite', 'anneeAcademique'])->findOrFail($userId);

            // Filtrer les modules par spécialité ET par semestre
            if ($user->specialite_id) {
                $modulesQuery = Module::where('specialite_id', $user->specialite_id);

                $modules = $semestre == 1
                    ? $modulesQuery->semestre1()->ordered()->get()
                    : $modulesQuery->semestre2()->ordered()->get();
            }

            if ($user->annee_academique_id) {
                $evaluations = Evaluation::where('user_id', $userId)
                    ->where('semestre', $semestre)
                    ->where('annee_academique_id', $user->annee_academique_id)
                    ->get()
                    ->keyBy('module_id');
            }
        }

        $users = User::with(['specialite', 'anneeAcademique'])->ordered()->get();

        return view('evaluations.saisir-multiple', compact('user', 'modules', 'evaluations', 'users', 'semestre'));
    }

    public function storeMultiple(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'semestre' => 'required|integer|in:1,2',
            'evaluations' => 'required|array',
            'evaluations.*.module_id' => 'required|exists:modules,id',
            'evaluations.*.note' => 'required|numeric|min:0|max:20',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($validated['user_id']);

            // Vérifier que tous les modules appartiennent à la spécialité de l'étudiant
            $moduleIds = collect($validated['evaluations'])->pluck('module_id');
            $invalidModules = Module::whereIn('id', $moduleIds)
                ->where('specialite_id', '!=', $user->specialite_id)
                ->exists();

            if ($invalidModules) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'Certains modules n\'appartiennent pas à la spécialité de l\'étudiant.');
            }

            foreach ($validated['evaluations'] as $evalData) {
                Evaluation::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'module_id' => $evalData['module_id'],
                        'semestre' => $validated['semestre'],
                        'annee_academique_id' => $user->annee_academique_id,
                    ],
                    [
                        'note' => $evalData['note'],
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('evaluations.saisir-multiple', [
                    'user_id' => $user->id,
                    'semestre' => $validated['semestre'],
                ])
                ->with('success', 'Évaluations enregistrées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement: '.$e->getMessage());
        }
    }

    public function releveNotes(User $user): View
    {
        $user->load(['specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $user->getEvaluationsBySemestre(2);

        $moyenneSemestre1 = $user->getMoyenneSemestre(1);
        $moyenneSemestre2 = $user->getMoyenneSemestre(2);

        return view('evaluations.releve-notes', compact(
            'user',
            'evaluationsSemestre1',
            'evaluationsSemestre2',
            'moyenneSemestre1',
            'moyenneSemestre2'
        ));
    }

    public function releveNotesPdf(User $user)
    {
        $user->load(['specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $user->getEvaluationsBySemestre(2);

        $moyenneSemestre1 = $user->getMoyenneSemestre(1);
        $moyenneSemestre2 = $user->getMoyenneSemestre(2);
        $moyenneGenerale = $this->calculerMoyenneGenerale($moyenneSemestre1, $moyenneSemestre2);

        $stats = $this->calculerStatistiques($evaluationsSemestre1, $evaluationsSemestre2);

        $pdf = Pdf::loadView('evaluations.releve-notes-pdf', compact(
            'user',
            'evaluationsSemestre1',
            'evaluationsSemestre2',
            'moyenneSemestre1',
            'moyenneSemestre2',
            'moyenneGenerale',
            'stats'
        ))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin_top' => 10,
                'margin_right' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
            ]);

        $filename = 'releve_notes_'.$user->matricule.'_'.now()->format('Ymd_His').'.pdf';

        return $pdf->download($filename);
    }

    private function calculerMoyenneGenerale($moyenneSemestre1, $moyenneSemestre2): float
    {
        if (empty($moyenneSemestre1) || empty($moyenneSemestre2)) {
            return 0;
        }

        return ($moyenneSemestre1 + $moyenneSemestre2) / 2;
    }

    private function calculerStatistiques($evaluationsSemestre1, $evaluationsSemestre2): array
    {
        $allEvaluations = $evaluationsSemestre1->merge($evaluationsSemestre2);

        $modulesValides = 0;
        $modulesEchoues = 0;

        foreach ($allEvaluations as $eval) {
            $note = $eval->note ?? 0;

            if ($note >= 10) {
                $modulesValides++;
            } else {
                $modulesEchoues++;
            }
        }

        return [
            'totalModules' => $allEvaluations->count(),
            'modulesValides' => $modulesValides,
            'modulesEchoues' => $modulesEchoues,
        ];
    }
}
