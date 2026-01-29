<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load(['specialite', 'anneeAcademique']);

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // 📸 Traitement de l'image de profil
        if ($request->hasFile('profile')) {
            $profilePath = $this->handleProfileImage($request->file('profile'));
            $validated['profile'] = $profilePath;
        }

        // Mettre à jour les informations de l'utilisateur
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Handle profile image upload and processing
     */
    private function handleProfileImage($file): ?string
    {
        if (! $file) {
            return null;
        }

        try {
            // 📁 Générer un nom de fichier unique
            $filename = 'profile_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            // 📁 Créer le dossier s'il n'existe pas (organisation par date)
            $path = 'profiles/'.date('Y/m');
            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0755, true);
            }

            // 🖼️ Optimiser l'image avec Intervention Image v3
            $manager = new ImageManager(new Driver);
            $image = $manager->read($file->getRealPath());

            // Redimensionner à 500x500 (portrait) avec crop
            $image->cover(500, 500);

            // Compresser et sauvegarder
            $fullPath = $path.'/'.$filename;
            $image->toJpeg(85)->save(Storage::disk('public')->path($fullPath));

            return $fullPath;

        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement de l\'image de profil: '.$e->getMessage());

            throw new \Exception('Erreur lors du traitement de l\'image. Veuillez réessayer.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
