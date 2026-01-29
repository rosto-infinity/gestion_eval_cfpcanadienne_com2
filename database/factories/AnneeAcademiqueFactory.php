<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AnneeAcademique;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnneeAcademiqueFactory extends Factory
{
    protected $model = AnneeAcademique::class;

    public function definition()
    {
        $year = $this->faker->year;

        return [
            'libelle' => $year.'-'.($year + 1),
            'is_active' => $this->faker->boolean,
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
        ];
    }
}
