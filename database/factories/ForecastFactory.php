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
            'expected_income' => $this->faker->randomFloat(2, 1000, 10000),
            'expected_expenses' => $this->faker->randomFloat(2, 500, 9000),
            'net_forecast' => $this->faker->randomFloat(2, 500, 1000),
            'user_id' => User::factory(),
        ];
    }
}
