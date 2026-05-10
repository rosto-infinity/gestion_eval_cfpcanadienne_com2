<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Module */
class ModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'intitule' => $this->intitule,
            'coefficient' => $this->coefficient,
            'ordre' => $this->ordre,
            'semestre' => $this->getSemestre(),

            // Coefficient depuis la table pivot lors d'un listing croisé
            'coefficient_pivot' => $this->whenPivotLoaded('module_specialite', fn () => $this->pivot->coefficient),

            'evaluations_count' => $this->whenCounted('evaluations'),

            'specialite' => new SpecialiteResource($this->whenLoaded('specialite')),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
