<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource ad-hoc sans modèle.
 * Structure les statistiques agrégées du tableau de bord.
 *
 * @property-read int|null $total_students
 * @property-read int|null $total_evaluations
 * @property-read int|null $total_specialites
 * @property-read int|null $total_modules
 * @property-read float|null $moyenne_generale
 * @property-read int|null $modules_count
 */
class DashboardStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_students' => $this->whenNotNull($this->total_students),
            'total_evaluations' => $this->whenNotNull($this->total_evaluations),
            'total_specialites' => $this->whenNotNull($this->total_specialites),
            'total_modules' => $this->whenNotNull($this->total_modules),
            'moyenne_generale' => $this->whenNotNull($this->moyenne_generale),
            'modules_count' => $this->whenNotNull($this->modules_count),
        ];
    }
}
