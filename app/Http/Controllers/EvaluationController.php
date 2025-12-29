<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use Illuminate\View\View;
use App\Models\Evaluation;
use App\Models\Specialite;
use App\Services\PdfService;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Http\JsonResponse;
use App\Services\EvaluationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreEvaluationRequest;

class EvaluationController extends Controller
{
 public function __construct(
        private EvaluationService $evaluationService,
        private PdfService $pdfService
    ) {}

    public function index(Request $request): View
    {
        $query = Evaluation::with(['user', 'module', 'specialite', 'anneeAcademique']);

        if ($userId = $request->input('user_id')) {
            $query->byUser((int) $userId);
        }

        if ($specialiteId = $request->input('specialite_id')) {
            $query->bySpecialite((int) $specialiteId);
        }

        if ($semestre = $request->input('semestre')) {
            $query->bySemestre((int) $semestre);
        }

        if ($anneeId = $request->input('annee_id')) {
            $query->byAnneeAcademique((int) $anneeId);
        }

        $evaluations = $query->latest()->paginate(20);
        $users = User::ordered()->get();
        $specialites = Specialite::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.index-evaluations', compact('evaluations', 'users', 'specialites', 'annees'));
    }

    /**
     * Formulaire de saisie par spécialité
     */
    public function saisirParSpecialite(Request $request): View
    {
        $specialiteId = $request->query('specialite_id');
        $moduleId = $request->query('module_id');
        $semestre = $request->query('semestre', 1);
        
        $specialites = Specialite::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();
        $anneeActive = AnneeAcademique::active()->first();
        
        $modules = collect();
        $students = collect();
        $specialite = null;
        $module = null;

        if ($specialiteId) {
            $specialite = Specialite::findOrFail($specialiteId);
            $modules = $this->evaluationService->getModulesBySpecialiteAndSemestre((int) $specialiteId, (int) $semestre);
        }

        if ($specialiteId && $moduleId && $anneeActive) {
            $module = Module::findOrFail($moduleId);
            $students = $this->evaluationService->getStudentsBySpecialiteAndSemestre(
                (int) $specialiteId,
                (int) $moduleId,
                (int) $semestre,
                $anneeActive->id
            );
        }

        return view('evaluations.saisir-par-specialite', compact(
            'specialites',
            'modules',
            'students',
            'specialite',
            'module',
            'semestre',
            'annees',
            'anneeActive'
        ));
    }

    /**
     * Enregistrement des notes par spécialité
     */
    public function storeParSpecialite(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'module_id' => 'required|exists:modules,id',
            'semestre' => 'required|integer|in:1,2',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'notes' => 'required|array',
            'notes.*' => 'required|numeric|min:0|max:20',
        ]);

        try {
            // Convertir explicitement en int pour le type hinting strict
            $result = $this->evaluationService->createMultipleEvaluations(
                (int) $validated['specialite_id'],
                (int) $validated['module_id'],
                (int) $validated['semestre'],
                (int) $validated['annee_academique_id'],
                $validated['notes']
            );

            $message = sprintf(
                '✅ %d évaluation(s) créée(s), %d mise(s) à jour',
                $result['created'],
                $result['updated']
            );

            if (!empty($result['errors'])) {
                $message .= sprintf(', %d erreur(s)', count($result['errors']));
            }

            return redirect()
                ->route('saisir-par-specialite', [
                    'specialite_id' => $validated['specialite_id'],
                    'module_id' => $validated['module_id'],
                    'semestre' => $validated['semestre'],
                ])
                ->with('success', $message);
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Erreur saisie évaluations par spécialité:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    /**
     * API: Récupère les modules d'une spécialité par AJAX
     */
    public function getModulesBySpecialite(int $specialiteId, int $semestre): JsonResponse
    {
        try {
            $modules = $this->evaluationService->getModulesBySpecialiteAndSemestre($specialiteId, $semestre);

            return response()->json([
                'success' => true,
                'modules' => $modules->map(fn($m) => [
                    'id' => $m->id,
                    'code' => $m->code,
                    'intitule' => $m->intitule,
                    'coefficient' => $m->coefficient,
                    'semestre' => $m->getSemestre(),
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Récupère les étudiants d'une spécialité avec leurs évaluations
     */
    public function getStudentsBySpecialite(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'module_id' => 'required|exists:modules,id',
            'semestre' => 'required|integer|in:1,2',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
        ]);

        try {
            $students = $this->evaluationService->getStudentsBySpecialiteAndSemestre(
                $validated['specialite_id'],
                $validated['module_id'],
                $validated['semestre'],
                $validated['annee_academique_id']
            );

            return response()->json([
                'success' => true,
                'students' => $students->map(fn($s) => [
                    'id' => $s->user->id,
                    'matricule' => $s->user->matricule,
                    'nom' => $s->user->nom,
                    'prenom' => $s->user->prenom,
                    'fullName' => $s->user->getFullName(),
                    'note' => $s->note,
                    'has_evaluation' => $s->has_evaluation,
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Statistiques pour un module
     */
    public function getModuleStatistics(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'semestre' => 'required|integer|in:1,2',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
        ]);

        try {
            $stats = $this->evaluationService->calculateModuleStatistics(
                $validated['module_id'],
                $validated['semestre'],
                $validated['annee_academique_id']
            );

            return response()->json([
                'success' => true,
                'statistics' => $stats,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function create(Request $request): View
    {
        $userId = $request->query('user_id');
        $user = $userId ? User::with(['specialite', 'anneeAcademique'])->findOrFail($userId) : null;

        $modules = collect();
        if ($user && $user->specialite_id) {
            $modules = Module::where('specialite_id', $user->specialite_id)->ordered()->get();
        }

        $users = User::with(['specialite', 'anneeAcademique'])->ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.create-evaluations', compact('modules', 'users', 'annees', 'user'));
    }

    public function getUserModules(User $user): JsonResponse
    {
        $user->load(['specialite', 'anneeAcademique']);

        $modules = collect();
        if ($user->specialite_id) {
            $modules = Module::where('specialite_id', $user->specialite_id)->ordered()->get();
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
            'modules' => $modules->map(fn($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'intitule' => $m->intitule,
                'semestre' => $m->getSemestre(),
                'coefficient' => $m->coefficient,
            ]),
        ]);
    }

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
            'modules' => $modules->map(fn($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'intitule' => $m->intitule,
                'semestre' => $m->getSemestre(),
                'coefficient' => $m->coefficient,
            ]),
        ]);
    }

    public function store(StoreEvaluationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $evaluation = $this->evaluationService->createEvaluation($validated);

            $user = $evaluation->user;
            $module = $evaluation->module;

            return redirect()
                ->route('evaluations.index')
                ->with('success', "✅ Évaluation créée avec succès pour {$user->getFullName()} - {$module->code}.");
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', '❌ ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Erreur création évaluation:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Erreur lors de la création: ' . $e->getMessage());
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

        $modules = collect();
        if ($evaluation->user && $evaluation->user->specialite_id) {
            $modules = Module::where('specialite_id', $evaluation->user->specialite_id)->ordered()->get();
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
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
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
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
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

            if ($user->specialite_id) {
                $modulesQuery = Module::where('specialite_id', $user->specialite_id);
                $modules = $semestre == 1
                    ? $modulesQuery->semestre1()->ordered()->get()
                    : $modulesQuery->semestre2()->ordered()->get();
            }

            if ($user->annee_academique_id) {
                $evaluations = $this->evaluationService->getEvaluationsBySemestre($user, (int) $semestre);
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
            $user = User::findOrFail($validated['user_id']);
            
            $this->evaluationService->createOrUpdateMultiple(
                $user,
                $validated['evaluations'],
                $validated['semestre']
            );

            return redirect()
                ->route('evaluations.saisir-multiple', [
                    'user_id' => $user->id,
                    'semestre' => $validated['semestre'],
                ])
                ->with('success', 'Évaluations enregistrées avec succès.');
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function releveNotes(User $user): View
    {
        $user->load(['specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $user->getEvaluationsBySemestre(2);

        $moyenneSemestre1 = $user->getMoyenneSemestre(1);
        $moyenneSemestre2 = $user->getMoyenneSemestre(2);
        $moyenneGenerale = $this->evaluationService->calculateMoyenneGenerale($moyenneSemestre1, $moyenneSemestre2);

        return view('evaluations.releve-notes', compact(
            'user',
            'evaluationsSemestre1',
            'evaluationsSemestre2',
            'moyenneSemestre1',
            'moyenneSemestre2',
            'moyenneGenerale'
        ));
    }

    public function releveNotesPdf(User $user)
    {
        $user->load(['specialite', 'anneeAcademique']);

        $evaluationsSemestre1 = $user->getEvaluationsBySemestre(1);
        $evaluationsSemestre2 = $user->getEvaluationsBySemestre(2);

        $moyenneSemestre1 = $user->getMoyenneSemestre(1);
        $moyenneSemestre2 = $user->getMoyenneSemestre(2);
        $moyenneGenerale = $this->evaluationService->calculateMoyenneGenerale($moyenneSemestre1, $moyenneSemestre2);
        $stats = $this->evaluationService->calculateStatistiques($evaluationsSemestre1, $evaluationsSemestre2);

        return $this->pdfService->generateReleveNotesPdf([
            'user' => $user,
            'evaluationsSemestre1' => $evaluationsSemestre1,
            'evaluationsSemestre2' => $evaluationsSemestre2,
            'moyenneSemestre1' => $moyenneSemestre1,
            'moyenneSemestre2' => $moyenneSemestre2,
            'moyenneGenerale' => $moyenneGenerale,
            'stats' => $stats,
        ]);
    }
}