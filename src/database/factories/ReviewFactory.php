<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'score_a' => fake()->numberBetween(0, 5),
            'score_b' => fake()->numberBetween(0, 5),
            'score_c' => fake()->numberBetween(0, 5),
        ];
    }
}
