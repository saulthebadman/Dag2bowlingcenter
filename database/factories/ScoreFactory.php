<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
// database/factories/ScoreFactory.php
public function definition(): array
{
    return [
        'datum' => fake()->date(),
        'waarde' => fake()->numberBetween(0, 100),
        'modus' => fake()->randomElement(['Arcade', 'Ranked', 'Training']),
    ];
}
