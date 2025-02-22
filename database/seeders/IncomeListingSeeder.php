<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeListing;

class IncomeListingSeeder extends Seeder
{
    public function run(): void
    {
        IncomeListing::factory()->count(2)->create();
    }
}
