<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEvaluationRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Récupère les règles de validation qui s'appliquent à la requête.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'module_id' => 'required|exists:modules,id',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'semestre' => 'required|integer|in:1,2',
            'note' => [
                'required',
                'numeric',
                'min:0',
                'max:20',
                $this->getUniqueEvaluationRule(), // ✅ Vérifier l'unicité
            ],
        ];
    }

    /**
     * -Récupère la règle d'unicité pour l'évaluation.
     * ✅ Vérifie que l'évaluation n'existe pas déjà
     */
    private function getUniqueEvaluationRule()
    {
        return Rule::unique('evaluations')
            ->where('user_id', $this->user_id)
            ->where('module_id', $this->module_id)
            ->where('semestre', $this->semestre)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->ignore($this->route('evaluation')); // ✅ Pour l'édition
    }

    /**
     * Messages de validation personnalisés.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'étudiant est obligatoire.',
            'user_id.exists' => 'L\'étudiant sélectionné n\'existe pas.',

            'module_id.required' => 'Le module est obligatoire.',
            'module_id.exists' => 'Le module sélectionné n\'existe pas.',

            'annee_academique_id.required' => 'L\'année académique est obligatoire.',
            'annee_academique_id.exists' => 'L\'année académique sélectionnée n\'existe pas.',

            'semestre.required' => 'Le semestre est obligatoire.',
            'semestre.integer' => 'Le semestre doit être un nombre entier.',
            'semestre.in' => 'Le semestre doit être 1 ou 2.',

            'note.required' => 'La note est obligatoire.',
            'note.numeric' => 'La note doit être un nombre.',
            'note.min' => 'La note ne peut pas être inférieure à 0.',
            'note.max' => 'La note ne peut pas dépasser 20.',
            'note.unique' => '⚠️ Une évaluation existe déjà pour cet étudiant dans ce module pour ce semestre et cette année.',
        ];
    }

    /**
     * -Préparer les données pour la validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => (int) $this->user_id,
            'module_id' => (int) $this->module_id,
            'annee_academique_id' => (int) $this->annee_academique_id,
            'semestre' => (int) $this->semestre,
            'note' => (float) $this->note,
        ]);
    }
}
