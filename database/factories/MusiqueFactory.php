<?php

namespace Database\Factories;

use App\Models\Musique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Musique>
 */
class MusiqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomMusique' => fake()->catchPhrase(),
            'duree' => fake()->randomFloat(2, 1, 10),
            'prix' => fake()->randomElement([0.00, 0.00, 0.99, 1.29]),
        ];
    }
}
