<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Academia\CloseAcademicYearAction;
use App\Models\AnneeAcademique;
use App\Models\Specialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('auth')]
#[Middleware('verified')]
#[Middleware('role:admin,superadmin')]
class AnneeAcademiqueController extends Controller
{
    public function index(): View
    {
        $annees = AnneeAcademique::paginate(5);

        return view('annees.index-annee', compact('annees'));
    }

    public function create(): View
    {
        $specialites = Specialite::all();
        $anneesAcademiques = AnneeAcademique::all();

        return view('annees.create-annee', compact('specialites', 'anneesAcademiques'));
    }

    public function store(Request $request, CloseAcademicYearAction $closeYear): RedirectResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques,libelle',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'is_active' => 'boolean',
        ]);

        try {
            $annee = AnneeAcademique::create($validated);

            if ($request->boolean('is_active')) {
                $closeYear->execute($annee);
            }

            return redirect()
                ->route('annees.index')
                ->with('success', 'Année académique créée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(AnneeAcademique $annee): View
    {
        $annee->loadCount(['users', 'evaluations', 'bilansCompetences']);

        return view('annees.show-annee', compact('annee'));
    }

    public function edit(AnneeAcademique $annee): View
    {
        return view('annees.edit-annee', compact('annee'));
    }

    public function update(Request $request, AnneeAcademique $annee, CloseAcademicYearAction $closeYear): RedirectResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques,libelle,'.$annee->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'is_active' => 'boolean',
        ]);

        try {
            $annee->update($validated);

            if ($request->boolean('is_active')) {
                $closeYear->execute($annee);
            }

            return redirect()
                ->route('annees.index')
                ->with('success', 'Année académique mise à jour avec succès.');
        } catch (\Exception $e) {
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

    public function activate(AnneeAcademique $annee, CloseAcademicYearAction $closeYear): RedirectResponse
    {
        try {
            $closeYear->execute($annee);

            return back()->with('success', 'Année académique activée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'activation: '.$e->getMessage());
        }
    }
}
