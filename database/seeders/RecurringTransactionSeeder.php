<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecurringTransaction;

class RecurringTransactionSeeder extends Seeder
{

    public function run(): void
    {
        RecurringTransaction::factory()->count(10)->create();
    }
}
