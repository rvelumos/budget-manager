<?php

namespace App\Traits;

use App\Models\Expense;
use App\Models\Income;

trait HasCurrentMonthData
{
    public function currentMonthExpenses()
    {
        $expenses = Expense::where('user_id', auth()->id())
            ->whereMonth('date', now()->month)
            ->with('category')
            ->get(['category_id', 'amount']);

        return response()->json($expenses);
    }

    public function currentMonthIncomes()
    {
        $incomes = Income::where('user_id', auth()->id())
            ->whereMonth('date', now()->month)
            ->with('category')
            ->get(['category_id', 'amount']);

        return response()->json($incomes);
    }
}
