<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function index(): View
    {
        // $modules = Module::withCount('evaluations')
        //     ->ordered()
        //     ->get();
        $modules = Module::get();

        $semestre1 = $modules->filter(fn ($m) => $m->isSemestre1());
        $semestre2 = $modules->filter(fn ($m) => $m->isSemestre2());

        return view('modules.index-modules', compact('modules', 'semestre1', 'semestre2'));
    }

    public function create(): View
    {
        return view('modules.create-modules');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:modules,code',
            'intitule' => 'required|string|max:100',
            'coefficient' => 'required|numeric|min:0.1|max:10',
            'ordre' => 'required|integer|min:1|max:100',
        ]);

        try {
            Module::create($validated);

            return redirect()
                ->route('modules.index')
                ->with('success', 'Module créé avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(Module $module): View
    {
        $module->loadCount('evaluations');

        $stats = [
            'semestre' => $module->getSemestre(),
            'total_evaluations' => $module->evaluations_count,
            'moyenne_generale' => $module->evaluations()->avg('note'),
        ];

        return view('modules.show-modules', compact('module', 'stats'));
    }

    public function edit(Module $module): View
    {
        return view('modules.edit-modules', compact('module'));
    }

    public function update(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:modules,code,'.$module->id,
            'intitule' => 'required|string|max:100',
            'coefficient' => 'required|numeric|min:0.1|max:10',
            'ordre' => 'required|integer|min:1|max:100',
        ]);

        try {
            $module->update($validated);

            return redirect()
                ->route('modules.index')
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

            $module->delete();

            return redirect()
                ->route('modules.index')
                ->with('success', 'Module supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }
}
