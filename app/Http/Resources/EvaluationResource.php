<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Evaluation */
class EvaluationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'semestre' => $this->semestre,
            'note' => $this->note,
            'appreciation' => $this->whenNotNull($this->appreciation),

            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'matricule' => $this->user->matricule,
            ]),
            'module' => new ModuleResource($this->whenLoaded('module')),
            'specialite' => new SpecialiteResource($this->whenLoaded('specialite')),
            'annee_academique' => new AnneeAcademiqueResource($this->whenLoaded('anneeAcademique')),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
