<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Niveau;
use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true; // À adapter selon vos permissions
    }

    /**
     * Récupère les règles de validation qui s'appliquent à la requête.
     */
    public function rules(): array
    {
        return [
            'matricule' => 'nullable|string|max:20|unique:users,matricule,' . $this->user->id,
            'name' => 'required|string|max:255',
            'role' => ['nullable', Rule::enum(Role::class)],
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'sexe' => 'nullable|in:M,F,Autre',
            'niveau' => 'nullable|in:' . implode(',', Niveau::values()),
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'specialite_id' => 'nullable|exists:specialites,id',
            'annee_academique_id' => 'nullable|exists:annees_academiques,id',
            
            // Informations civiles
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:100',
            'nationalite' => 'nullable|string|max:50',
            
            // Contact
            'telephone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'telephone_urgence' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'adresse' => 'nullable|string|max:500',
            
            // Documents
            'piece_identite' => 'nullable|string|max:50',
            
            // Statut
            'statut' => 'nullable|in:actif,inactif,suspendu,archive',
        ];
    }

    /**
     * Messages de validation personnalisés en français
     */
    public function messages(): array
    {
        return [
            'matricule.unique' => 'Ce matricule existe déjà.',
            'matricule.string' => 'Le matricule doit être une chaîne de caractères.',
            'matricule.max' => 'Le matricule ne doit pas dépasser 20 caractères.',
            
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            
            'role.enum' => 'Le rôle sélectionné n\'existe pas.',
            
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.uppercase' => 'Le mot de passe doit contenir au moins une majuscule.',
            'password.lowercase' => 'Le mot de passe doit contenir au moins une minuscule.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un caractère spécial.',
            
            'sexe.in' => 'Le sexe doit être : M, F ou Autre.',
            
            'niveau.in' => 'Le niveau sélectionné n\'existe pas.',
            
            'profile.image' => 'Le fichier doit être une image valide.',
            'profile.mimes' => 'L\'image doit être au format JPG, JPEG, PNG ou GIF.',
            'profile.max' => 'L\'image ne doit pas dépasser 2 MB.',
            
            'specialite_id.exists' => 'La spécialité sélectionnée n\'existe pas.',
            'annee_academique_id.exists' => 'L\'année académique sélectionnée n\'existe pas.',
            
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être dans le passé.',
            
            'lieu_naissance.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'lieu_naissance.max' => 'Le lieu de naissance ne doit pas dépasser 100 caractères.',
            
            'nationalite.string' => 'La nationalité doit être une chaîne de caractères.',
            'nationalite.max' => 'La nationalité ne doit pas dépasser 50 caractères.',
            
            'telephone.string' => 'Le téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le téléphone ne doit pas dépasser 20 caractères.',
            'telephone.regex' => 'Le format du téléphone est invalide.',
            
            'telephone_urgence.string' => 'Le téléphone d\'urgence doit être une chaîne de caractères.',
            'telephone_urgence.max' => 'Le téléphone d\'urgence ne doit pas dépasser 20 caractères.',
            'telephone_urgence.regex' => 'Le format du téléphone d\'urgence est invalide.',
            
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'adresse.max' => 'L\'adresse ne doit pas dépasser 500 caractères.',
            
            'piece_identite.string' => 'La pièce d\'identité doit être une chaîne de caractères.',
            'piece_identite.max' => 'La pièce d\'identité ne doit pas dépasser 50 caractères.',
            
            'statut.in' => 'Le statut doit être : actif, inactif, suspendu ou archive.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages
     */
    public function attributes(): array
    {
        return [
            'matricule' => 'matricule',
            'name' => 'nom',
            'role' => 'rôle',
            'email' => 'email',
            'password' => 'mot de passe',
            'password_confirmation' => 'confirmation du mot de passe',
            'sexe' => 'sexe',
            'niveau' => 'niveau',
            'profile' => 'photo de profil',
            'specialite_id' => 'spécialité',
            'annee_academique_id' => 'année académique',
            'date_naissance' => 'date de naissance',
            'lieu_naissance' => 'lieu de naissance',
            'nationalite' => 'nationalité',
            'telephone' => 'téléphone',
            'telephone_urgence' => 'téléphone d\'urgence',
            'adresse' => 'adresse',
            'piece_identite' => 'pièce d\'identité',
            'statut' => 'statut',
        ];
    }
}
