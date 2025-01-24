<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('forecast_period_start');
            $table->date('forecast_period_end');
            $table->decimal('expected_income', 10, 2)->default(0);
            $table->decimal('expected_expenses', 10, 2)->default(0);
            $table->decimal('net_forecast', 10, 2)->virtualAs('expected_income - expected_expenses');
            $table->json('categories')->nullable();
            $table->decimal('accuracy_rate', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
