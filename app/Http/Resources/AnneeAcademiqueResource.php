<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AnneeAcademique */
class AnneeAcademiqueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'date_debut' => $this->date_debut?->format('Y-m-d'),
            'date_fin' => $this->date_fin?->format('Y-m-d'),
            'is_active' => $this->is_active,
            'statut' => $this->when($this->is_active, 'Année Actuelle'),

            'users_count' => $this->whenCounted('users'),
            'evaluations_count' => $this->whenCounted('evaluations'),
            'bilans_competences_count' => $this->whenCounted('bilansCompetences'),

            'moyenne_generale' => $this->whenAggregated('evaluations', 'note', 'avg'),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
