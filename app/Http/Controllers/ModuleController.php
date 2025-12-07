<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function index(Request $request): View
    {
        $specialites = Specialite::orderBy('intitule')->get();
        $selectedSpecialite = $request->get('specialite_id');

        $query = Module::with('specialite')->withCount('evaluations');

        if ($selectedSpecialite) {
            $query->where('specialite_id', $selectedSpecialite);
        }

        $modules = $query->ordered()->get();

        $semestre1 = $modules->filter(fn ($m) => $m->isSemestre1());
        $semestre2 = $modules->filter(fn ($m) => $m->isSemestre2());

        return view('modules.index-modules', compact('modules', 'semestre1', 'semestre2', 'specialites', 'selectedSpecialite'));
    }

    public function create(): View
    {
        $specialites = Specialite::orderBy('intitule')->get();

        return view('modules.create-modules', compact('specialites'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'code' => 'required|string|max:10',
            'intitule' => 'required|string|max:100',
            'coefficient' => 'required|numeric|min:0.1|max:10',
            'ordre' => 'required|integer|min:1|max:100',
        ]);

        // Vérifier l'unicité du code par spécialité
        $exists = Module::where('specialite_id', $validated['specialite_id'])
            ->where('code', $validated['code'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['code' => 'Ce code existe déjà pour cette spécialité.']);
        }

        try {
            Module::create($validated);

            return redirect()
                ->route('modules.index', ['specialite_id' => $validated['specialite_id']])
                ->with('success', 'Module créé avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(Module $module): View
    {
        $module->load('specialite')->loadCount('evaluations');

        $stats = [
            'semestre' => $module->getSemestre(),
            'total_evaluations' => $module->evaluations_count,
            'moyenne_generale' => $module->evaluations()->avg('note'),
        ];

        return view('modules.show-modules', compact('module', 'stats'));
    }

    public function edit(Module $module): View
    {
        $specialites = Specialite::orderBy('intitule')->get();

        return view('modules.edit-modules', compact('module', 'specialites'));
    }

    public function update(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'code' => 'required|string|max:10',
            'intitule' => 'required|string|max:100',
            'coefficient' => 'required|numeric|min:0.1|max:10',
            'ordre' => 'required|integer|min:1|max:100',
        ]);

        // Vérifier l'unicité du code par spécialité (sauf pour le module actuel)
        $exists = Module::where('specialite_id', $validated['specialite_id'])
            ->where('code', $validated['code'])
            ->where('id', '!=', $module->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['code' => 'Ce code existe déjà pour cette spécialité.']);
        }

        try {
            $module->update($validated);

            return redirect()
                ->route('modules.index', ['specialite_id' => $validated['specialite_id']])
                ->with('success', 'Module mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(Module $module): RedirectResponse
    {
        try {
            if ($module->evaluations()->exists()) {
                return back()->with('error', 'Impossible de supprimer un module avec des évaluations.');
            }

            $specialiteId = $module->specialite_id;
            $module->delete();

            return redirect()
                ->route('modules.index', ['specialite_id' => $specialiteId])
                ->with('success', 'Module supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }
}
