<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use Illuminate\View\View;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Evaluation::with(['user', 'module', 'anneeAcademique']);

        if ($userId = $request->input('user_id')) {
            $query->byUser((int)$userId);
        }

        if ($semestre = $request->input('semestre')) {
            $query->bySemestre((int)$semestre);
        }

        if ($anneeId = $request->input('annee_id')) {
            $query->byAnneeAcademique((int)$anneeId);
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
        // dd($user);
        $modules = Module::ordered()->get();
        $users = User::with(['specialite', 'anneeAcademique'])->ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('evaluations.create-evaluations', compact('modules', 'users', 'annees', 'user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'semestre' => 'required|integer|in:1,2',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        try {
            // Vérifier si l'évaluation existe déjà
            $exists = Evaluation::where('user_id', $validated['user_id'])
                ->where('module_id', $validated['module_id'])
                ->where('semestre', $validated['semestre'])
                ->where('annee_academique_id', $validated['annee_academique_id'])
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', 'Cette évaluation existe déjà pour cet étudiant.');
            }

            Evaluation::create($validated);

            return redirect()
                ->route('evaluations.index')
                ->with('success', 'Évaluation créée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function show(Evaluation $evaluation): View
    {
        $evaluation->load(['user.specialite', 'module', 'anneeAcademique']);

        return view('evaluations.show-evaluations', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation): View
    {
        $evaluation->load(['user', 'module', 'anneeAcademique']);
        
        $modules = Module::ordered()->get();
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
            
            $modules = $semestre == 1 
                ? Module::semestre1()->ordered()->get()
                : Module::semestre2()->ordered()->get();

            $evaluations = Evaluation::where('user_id', $userId)
                ->where('semestre', $semestre)
                ->where('annee_academique_id', $user->annee_academique_id)
                ->get()
                ->keyBy('module_id');
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
                    'semestre' => $validated['semestre']
                ])
                ->with('success', 'Évaluations enregistrées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
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

        $pdf = Pdf::loadView('evaluations.releve-notes-pdf', compact(
            'user',
            'evaluationsSemestre1',
            'evaluationsSemestre2',
            'moyenneSemestre1',
            'moyenneSemestre2'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $filename = 'releve_notes_' . $user->matricule . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}

