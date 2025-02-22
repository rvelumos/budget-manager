<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function manageUsers(): View|Factory|Application
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function runReports(): View|Factory|Application
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        return view('admin.reports.index', compact('totalIncome', 'totalExpense'));
    }
}
