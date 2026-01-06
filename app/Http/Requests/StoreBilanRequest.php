<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBilanRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la création d'un bilan.
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                // Règle personnalisée pour vérifier que l'étudiant n'a pas déjà de bilan pour l'année active
                // (Ceci est une couche de sécurité, la logique métier principale reste dans le Service)
                function ($attribute, $value, $fail): void {
                    $user = \App\Models\User::find($value);
                    if ($user && $user->annee_academique_id) {
                        $exists = \App\Models\BilanCompetence::where('user_id', $value)
                            ->where('annee_academique_id', $user->annee_academique_id)
                            ->exists();
                        if ($exists) {
                            $fail('Cet étudiant possède déjà un bilan de compétences pour l\'année en cours.');
                        }
                    }
                },
            ],
            'moy_competences' => 'required|numeric|min:0|max:20',
            'observations' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Vous devez sélectionner un étudiant.',
            'user_id.exists' => 'L\'étudiant sélectionné n\'existe pas.',
            'moy_competences.required' => 'La moyenne des compétences est obligatoire.',
            'moy_competences.numeric' => 'La moyenne doit être un nombre.',
            'moy_competences.min' => 'La moyenne ne peut pas être inférieure à 0.',
            'moy_competences.max' => 'La moyenne ne peut pas dépasser 20.',
            'observations.max' => 'Les observations ne doivent pas dépasser 1000 caractères.',
        ];
    }
}
