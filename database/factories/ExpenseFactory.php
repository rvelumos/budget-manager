<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\ExpenseListing;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'expense_listing_id' => ExpenseListing::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 5000),
            'date' => $this->faker->date,
         ];
    }
}
