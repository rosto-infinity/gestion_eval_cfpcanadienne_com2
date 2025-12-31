<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfirmDeleteSpecialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
          return true;
    }

    public function rules(): array
    {
        return [
            'action' => [
                'required',
                Rule::in(['delete_with_transfer', 'delete_all', 'keep_specialite']),
            ],
            'new_specialite_id' => [
                'required_if:action,delete_with_transfer',
                'exists:specialites,id',
                'different:specialite_id',
            ],
            'confirm_delete_all' => [
                'required_if:action,delete_all',
                'accepted',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'action.required' => '❌ Veuillez sélectionner une action à effectuer.',
            'action.in' => '❌ Action non valide. Veuillez choisir une action valide.',
            
            'new_specialite_id.required_if' => '❌ Veuillez sélectionner une spécialité de destination pour le transfert.',
            'new_specialite_id.exists' => '❌ La spécialité sélectionnée n\'existe pas.',
            'new_specialite_id.different' => '❌ Vous ne pouvez pas transférer vers la même spécialité.',
            
            'confirm_delete_all.required_if' => '❌ Veuillez cocher la case de confirmation pour supprimer TOUTES les données associées.',
            'confirm_delete_all.accepted' => '❌ Vous devez confirmer que vous voulez supprimer TOUTES les données associées.',
        ];
    }
}