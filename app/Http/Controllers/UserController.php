<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Specialite;
use App\Models\AnneeAcademique;
use App\Enums\Niveau;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        // ✅ IMPORTANT : Charger les relations AVANT paginate()
        $query = User::query()
            ->with(['specialite', 'anneeAcademique']);

        // Recherche
        if ($search = $request->input('search')) {
            $query->search($search);
        }

        // Filtre par spécialité
        if ($specialiteId = $request->input('specialite_id')) {
            $query->where('specialite_id', $specialiteId);
        }

        // Filtre par année académique
        if ($anneeId = $request->input('annee_id')) {
            $query->where('annee_academique_id', $anneeId);
        }

        // ✅ Paginer APRÈS avoir construit la query
        $users = $query->ordered()->paginate(20);

        $specialites = Specialite::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();

        return view('users.index', compact('users', 'specialites', 'annees'));
    }

    public function create(): View
    {
        $specialites = Specialite::ordered()->get();
        $anneesAcademiques = AnneeAcademique::ordered()->get();
        $niveaux = Niveau::grouped();

        return view('users.create', compact('specialites', 'anneesAcademiques', 'niveaux'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:20|unique:users,matricule',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'sexe' => 'required|in:M,F,Autre',
            'niveau' => 'required|in:' . implode(',', Niveau::values()),
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'specialite_id' => 'required|exists:specialites,id',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
        ]);

        try {
            // Upload de la photo de profil
            if ($request->hasFile('profile')) {
                $validated['profile'] = $request->file('profile')->store('profiles', 'public');
            }

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant créé avec succès.');
        } catch (\Exception $e) {
            // Supprimer le fichier uploadé en cas d'erreur
            if (isset($validated['profile'])) {
                Storage::disk('public')->delete($validated['profile']);
            }

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function show(User $user): View
    {
        $user->load(['specialite', 'anneeAcademique', 'evaluations.module', 'bilanCompetence']);

        $stats = [
            'total_evaluations' => $user->evaluations()->count(),
            'evaluations_semestre1' => $user->evaluations()->where('semestre', 1)->count(),
            'evaluations_semestre2' => $user->evaluations()->where('semestre', 2)->count(),
            'moyenne_semestre1' => $user->getMoyenneSemestre(1),
            'moyenne_semestre2' => $user->getMoyenneSemestre(2),
            'has_bilan' => $user->bilanCompetence !== null,
        ];

        return view('users.show', compact('user', 'stats'));
    }

    public function edit(User $user): View
    {
        $user->load(['specialite', 'anneeAcademique']);
        
        $specialites = Specialite::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();
        $niveaux = Niveau::grouped();

        return view('users.edit', compact('user', 'specialites', 'annees', 'niveaux'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:20|unique:users,matricule,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'sexe' => 'required|in:M,F,Autre',
            'niveau' => 'required|in:' . implode(',', Niveau::values()),
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'specialite_id' => 'required|exists:specialites,id',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
        ]);

        try {
            // Upload de la nouvelle photo
            if ($request->hasFile('profile')) {
                // Supprimer l'ancienne photo
                if ($user->profile) {
                    Storage::disk('public')->delete($user->profile);
                }
                $validated['profile'] = $request->file('profile')->store('profiles', 'public');
            }

            // Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()
                ->route('users.show', $user)
                ->with('success', 'Étudiant mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            // Vérifier si l'utilisateur a des évaluations
            if ($user->evaluations()->exists()) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec des évaluations.');
            }

            // Vérifier si l'utilisateur a un bilan
            if ($user->bilanCompetence) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec un bilan de compétences.');
            }

            // Supprimer la photo de profil
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }

            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
