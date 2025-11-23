<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Specialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnneeAcademiqueController extends Controller
{
    public function index(): View
    {
        // $annees = AnneeAcademique::withCount('users')
        $annees = AnneeAcademique::paginate(15);

        return view('annees.index-annee', compact('annees'));
    }

    public function create(): View
    {
        $specialites = Specialite::all();
        $anneesAcademiques = AnneeAcademique::all();

        return view('annees.create-annee', compact('specialites', 'anneesAcademiques'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques,libelle',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $annee = AnneeAcademique::create($validated);

            if ($request->boolean('is_active')) {
                $annee->activate();
            }

            DB::commit();

            return redirect()
                ->route('annees.index')
                ->with('success', 'Année académique créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(AnneeAcademique $annee): View
    {
        $annee->loadCount(['users', 'evaluations', 'bilansCompetences']);

        $stats = [
            'total_etudiants' => $annee->users_count,
            'total_evaluations' => $annee->evaluations_count,
            'total_bilans' => $annee->bilans_competences_count,
        ];

        return view('annees.show-annee', compact('annee', 'stats'));
    }

    public function edit(AnneeAcademique $annee): View
    {
        return view('annees.edit-annee', compact('annee'));
    }

    public function update(Request $request, AnneeAcademique $annee): RedirectResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques,libelle,'.$annee->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $annee->update($validated);

            if ($request->boolean('is_active')) {
                $annee->activate();
            }

            DB::commit();

            return redirect()
                ->route('annees.index')
                ->with('success', 'Année académique mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(AnneeAcademique $annee): RedirectResponse
    {
        try {
            if ($annee->is_active) {
                return back()->with('error', 'Impossible de supprimer l\'année active.');
            }

            if ($annee->users()->exists()) {
                return back()->with('error', 'Impossible de supprimer une année avec des étudiants.');
            }

            $annee->delete();

            return redirect()
                ->route('annees.index')
                ->with('success', 'Année académique supprimée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    public function activate(AnneeAcademique $annee): RedirectResponse
    {
        try {
            $annee->activate();

            return back()->with('success', 'Année académique activée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'activation: '.$e->getMessage());
        }
    }
}
