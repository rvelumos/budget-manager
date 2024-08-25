<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'source' => $this->faker->word,
            'date' => $this->faker->date,
         ];
    }
}
