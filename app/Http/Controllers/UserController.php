<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Niveau;
use App\Enums\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AnneeAcademique;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        // ✅ IMPORTANT : Charger les relations AVANT paginate()
        $query = User::query()
            ->with(['specialite', 'anneeAcademique']);
        // dd($query);
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
        // dd($specialites, $annees);

        return view('users.index', compact('users', 'specialites', 'annees'));
    }

    public function create(): View
    {
        $specialites = Specialite::ordered()->get();
        $anneesAcademiques = AnneeAcademique::ordered()->get();
        $niveaux = Niveau::grouped();

        return view('users.create', compact('specialites', 'anneesAcademiques', 'niveaux'));
    }

    /**
     * Stocke un nouvel utilisateur
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // 📸 Traitement de l'image
            if ($request->hasFile('profile')) {
                $validated['profile'] = $this->handleProfileImage($request->file('profile'));
            }

            // 🔐 Hash du mot de passe
            $validated['password'] = Hash::make($validated['password']);

            // 💾 Création de l'utilisateur
            User::create($validated);

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur UserController@store: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
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
        // On récupère les options du rôle via notre Enum (Standard 2025)
        $roles = Role::cases();
        $user->load(['specialite', 'anneeAcademique']);

        $specialites = Specialite::ordered()->get();
        $anneesAcademiques = AnneeAcademique::ordered()->get();
        // CORRECTION : Récupérer les cases de l'Enum Niveau
        $niveaux = \App\Enums\Niveau::cases();

        return view('users.edit', compact('user', 'specialites', 'anneesAcademiques', 'niveaux', 'roles'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // 📸 Traitement de la nouvelle image
            if ($request->hasFile('profile')) {
                if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                    Storage::disk('public')->delete($user->profile);
                }
                $validated['profile'] = $this->handleProfileImage($request->file('profile'));
            }

            // 🔐 Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            // 💾 Mise à jour
            $user->update($validated);

            return redirect()
                ->route('users.show', $user)
                ->with('success', 'Étudiant mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur UserController@update: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            // --Vérifier si l'utilisateur a des évaluations
            if ($user->evaluations()->exists()) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec des évaluations.');
            }

            // --Vérifier si l'utilisateur a un bilan
            if ($user->bilanCompetence) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec un bilan de compétences.');
            }

            // --Supprimer la photo de profil
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }

            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    /**
     * 📸 Traite et optimise l'image de profil
     *
     * Handles processing and storage of uploaded profile images for users.
     * - Redimensionne l'image à 500x500 pixels
     * - Compresse l'image en JPG avec qualité 85%
     * - Organise les fichiers par date (Y/m)
     * - Génère un nom de fichier unique et sécurisé
     *
     * @param  \Illuminate\Http\UploadedFile  $file  Le fichier uploadé
     * @return string Chemin du fichier stocké (ex: profiles/2025/01/profile_nom_1735862400.jpg)
     *
     * @throws \Exception Si le traitement de l'image échoue
     */
    private function handleProfileImage($file): string
    {
        try {
            // 🎯 Générer un nom unique et sécurisé
            $filename = 'profile_'.$file->getClientOriginalName();
            $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME))
                .'_'.time()
                .'.'.$file->getClientOriginalExtension();

            // 📁 Créer le dossier s'il n'existe pas (organisation par date)
            $path = 'profiles/'.date('Y/m');
            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0755, true);
            }

            // 🖼️ Optimiser l'image avec Intervention Image
            $image = Image::make($file->getRealPath());

            // Redimensionner à 500x500 (portrait)
            $image->fit(500, 500, function ($constraint): void {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Compresser et sauvegarder
            $fullPath = $path.'/'.$filename;
            $image->encode('jpg', 85)->save(Storage::disk('public')->path($fullPath));

            return $fullPath;

        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement de l\'image: '.$e->getMessage());

            throw new \Exception('Erreur lors du traitement de l\'image: '.$e->getMessage());
        }
    }
}
