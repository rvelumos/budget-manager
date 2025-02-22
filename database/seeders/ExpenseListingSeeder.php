<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseListing;

class ExpenseListingSeeder extends Seeder
{
    public function run(): void
    {
        ExpenseListing::factory()->count(2)->create();
    }
}
