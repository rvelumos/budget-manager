<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class ForecastController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;

        $totalIncome = Income::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->sum('amount');

        $totalExpense = Expense::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->sum('amount');

        $netSavings = $totalIncome - $totalExpense;

        $expensesByCategory = Expense::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->with('category')
            ->selectRaw('category_id, SUM(amount) as total_amount')
            ->groupBy('category_id')
            ->get();

        return view('forecast.index', compact('totalIncome', 'totalExpense', 'netSavings', 'expensesByCategory'));
    }

    public function export()
    {
        $currentMonth = now()->month;

        $expenses = Expense::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->with('category')
            ->get();

        $csvData = "Category,Amount\n";
        foreach ($expenses as $expense) {
            $csvData .= "{$expense->category->name},{$expense->amount}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="forecast.csv"');
    }

}
