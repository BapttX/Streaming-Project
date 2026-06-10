<?php

namespace Database\Factories;

use App\Models\Musique;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'nomMusique' => Str::limit(fake()->catchPhrase(), 50, ''),
            'duree' => fake()->randomFloat(2, 1, 10),
            'prix' => fake()->randomElement([0.00, 0.00, 0.99, 1.29]),
        ];
    }
}
