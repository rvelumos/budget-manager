<?php

namespace Database\Factories;
use App\Models\Category;
use App\Models\Income;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;


class IncomeFactory extends Factory
{

    public function definition(): array
    {
         return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'category_id' => category::factory(),
            'source' => $this->faker->word,
            'date' => $this->faker->date,
         ];
    }
}
