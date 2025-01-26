<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'period' => $this->faker->randomElement(['weekly', 'monthly', 'yearly']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
        ];
    }
}
