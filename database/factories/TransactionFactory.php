<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'description' => $this->faker->sentence,
            'date' => $this->faker->date,
        ];
    }
}
