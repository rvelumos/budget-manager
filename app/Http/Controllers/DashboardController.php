<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index(): View|Factory|Application
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

        return view('dashboard.index', compact('totalIncome', 'totalExpense', 'netSavings', 'expensesByCategory'));
    }
}
