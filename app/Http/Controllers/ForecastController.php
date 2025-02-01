<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ForecastController extends Controller
{
    public function index(): View|Factory|Application
    {
        $currentMonth = now()->month;

        $totalIncome = RecurringTransaction::whereMonth('start_date', $currentMonth)
            ->where('user_id', auth()->id())
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->where('type', 'expense')
            ->sum('amount');

        $netSavings = $totalIncome - $totalExpense;

        $expensesByCategory = Transaction::whereMonth('date', $currentMonth)
            ->where('user_id', auth()->id())
            ->where('type', 'expense')
            ->with('category')
            ->get();

        $forecasts = (object)[
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netSavings' => $netSavings,
            'expensesByCategory' => $expensesByCategory,
        ];

        return view('forecasts.index', compact('forecasts'));
    }

    public function export(): Application|Response|ResponseFactory
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
            ->header('Content-Disposition', 'attachment; filename="forecasts.csv"');
    }

}
