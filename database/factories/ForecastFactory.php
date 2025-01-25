<?php

namespace Database\Factories;

use App\Models\Forecast;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForecastFactory extends Factory
{

    protected $model = Forecast::class;

    public function definition()
    {
        return [
            'month' => $this->faker->date('Y-m-01'),
            'total_income' => $this->faker->randomFloat(2, 1000, 10000),
            'total_expense' => $this->faker->randomFloat(2, 500, 9000),
            'net_savings' => fn (array $attributes) => $attributes['total_income'] - $attributes['total_expense'],
            'user_id' => User::factory(),
        ];
    }
}
