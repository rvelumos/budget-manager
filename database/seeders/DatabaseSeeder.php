<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            ExpenseListingSeeder::class,
            ExpenseSeeder::class,
            ForecastSeeder::class,
            IncomeListingSeeder::class,
            IncomeSeeder::class,
            RecurringTransactionSeeder::class,
            TransactionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
