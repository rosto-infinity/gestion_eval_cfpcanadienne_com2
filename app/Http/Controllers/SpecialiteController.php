<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpecialiteController extends Controller
{
    public function index(Request $request): View
    {
        $query = Specialite::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        $specialites = $query->withCount('users')
            ->ordered()
            ->paginate(15);

        return view('specialites.index', compact('specialites'));
    }

    public function create(): View
    {
        return view('specialites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:specialites,code',
            'intitule' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        try {
            Specialite::create($validated);

            return redirect()
                ->route('specialites.index')
                ->with('success', 'Spécialité créée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(Specialite $specialite): View
    {
        $specialite->loadCount('users');

        $stats = [
            'total_etudiants' => $specialite->getUsersCount(),
            'etudiants_actifs' => $specialite->getActiveUsersCount(),
        ];

        $etudiants = $specialite->users()
            ->with(['anneeAcademique'])
            ->ordered()
            ->paginate(20);

        return view('specialites.show', compact('specialite', 'stats', 'etudiants'));
    }

    public function edit(Specialite $specialite): View
    {
        return view('specialites.edit', compact('specialite'));
    }

    public function update(Request $request, Specialite $specialite): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:specialites,code,'.$specialite->id,
            'intitule' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        try {
            $specialite->update($validated);

            return redirect()
                ->route('specialites.index')
                ->with('success', 'Spécialité mise à jour avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(Specialite $specialite): RedirectResponse
    {
        try {
            if ($specialite->users()->exists()) {
                return back()->with('error', 'Impossible de supprimer une spécialité avec des étudiants.');
            }

            $specialite->delete();

            return redirect()
                ->route('specialites.index')
                ->with('success', 'Spécialité supprimée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }
}
