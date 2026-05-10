<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource ad-hoc sans modèle.
 * Structure la sortie de ComputeMasteryMatrixAction.
 *
 * @property-read int $student_id
 * @property-read string $student_name
 * @property-read string|null $student_matricule
 * @property-read string|null $specialite
 * @property-read float $overall_average
 * @property-read array $overall_level
 * @property-read int $modules_count
 * @property-read int $modules_maitrises
 * @property-read float $taux_maitrise
 * @property-read array $modules
 */
class MasteryMatrixResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student' => [
                'id' => $this->student_id,
                'name' => $this->student_name,
                'matricule' => $this->student_matricule,
            ],
            'specialite' => $this->specialite,
            'performance' => [
                'overall_average' => $this->overall_average,
                'overall_level' => $this->overall_level['label'],
                'overall_level_key' => $this->overall_level['key'],
            ],
            'maitrise' => [
                'modules_count' => $this->modules_count,
                'modules_maitrises' => $this->modules_maitrises,
                'taux_maitrise' => $this->taux_maitrise,
            ],
            'modules' => $this->modules,
        ];
    }
}
