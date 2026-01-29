<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Specialite;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialiteFactory extends Factory
{
    protected $model = Specialite::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lexify('SPEC-???'),
            'intitule' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence,
        ];
    }
}
