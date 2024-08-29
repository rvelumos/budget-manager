<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/expenses/current-month', [ExpenseController::class, 'currentMonth']);
    Route::get('/incomes/current-month', [IncomeController::class, 'currentMonth']);
});

?>
