<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\BilanCompetence;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BilanCompetence */
class BilanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'moy_semestre1' => $this->moy_eval_semestre1,
            'moy_semestre2' => $this->moy_eval_semestre2,
            'moy_evaluations' => $this->moy_evaluations,
            'moy_competences' => $this->moy_competences,
            'moyenne_generale' => $this->moyenne_generale,
            'appreciation' => $this->whenNotNull($this->moyenne_generale !== null ? $this->getAppreciation() : null),
            'mention' => $this->whenNotNull($this->moyenne_generale !== null ? $this->getMention() : null),
            'is_admis' => $this->whenNotNull($this->moyenne_generale !== null ? $this->isAdmis() : null),
            'observations' => $this->whenNotNull($this->observations),

            'moyenne_evaluations_brute' => $this->whenAggregated('evaluations', 'note', 'avg'),

            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'matricule' => $this->user->matricule,
            ]),
            'annee_academique' => new AnneeAcademiqueResource($this->whenLoaded('anneeAcademique')),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
