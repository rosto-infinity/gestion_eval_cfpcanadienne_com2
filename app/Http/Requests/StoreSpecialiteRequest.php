<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpecialiteRequest extends FormRequest
{
    public function authorize(): bool
    {
          return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('specialites', 'code')->whereNull('deleted_at'),
            ],
            'intitule' => [
                'required',
                'string',
                'max:100',
                Rule::unique('specialites', 'intitule')->whereNull('deleted_at'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Messages pour le code
            'code.required' => '❌ Le code de la spécialité est obligatoire.',
            'code.string' => '❌ Le code doit être une chaîne de caractères.',
            'code.max' => '❌ Le code ne doit pas dépasser 20 caractères.',
            'code.unique' => '❌ Ce code de spécialité est déjà utilisé. Veuillez choisir un autre code.',

            // Messages pour l'intitulé
            'intitule.required' => '❌ L\'intitulé de la spécialité est obligatoire.',
            'intitule.string' => '❌ L\'intitulé doit être une chaîne de caractères.',
            'intitule.max' => '❌ L\'intitulé ne doit pas dépasser 100 caractères.',
            'intitule.unique' => '❌ Cette spécialité existe déjà. Veuillez choisir un autre intitulé.',

            // Messages pour la description
            'description.string' => '❌ La description doit être une chaîne de caractères.',
            'description.max' => '❌ La description ne doit pas dépasser 500 caractères.',
        ];
    }
}