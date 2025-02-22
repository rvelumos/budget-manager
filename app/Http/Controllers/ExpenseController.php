<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseListing;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\HasCurrentMonthData;
use Illuminate\Routing\Controller;


class ExpenseController extends Controller
{
    use HasCurrentMonthData;

     public function index(ExpenseListing $expenseList): View|Factory|Application
     {
        $expenses = $expenseList->expenses()->with('category')->get();

        return view('expenses.index', compact('expenseList', 'expenses'));
    }

     public function create(ExpenseListing $expenseList): View|Factory|Application
     {
        return view('expenses.create', compact('expenseList'));
    }

    public function store(Request $request, ExpenseListing $expenseList): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'expense_listing_id' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $expenseList->expenses()->create([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'expense_listing_id' => $request->expense_listing_id,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expenses.index', $expenseList)->with('success', __('messages.expense_created'));
    }

    public function edit(ExpenseListing $expenseList, Expense $expense): View|Factory|Application
    {
        return view('expenses.edit', compact('expenseList', 'expense'));
    }

    public function update(Request $request, ExpenseListing $expenseList, Expense $expense): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index', $expenseList)->with('success', __('messages.expense_updated'));
    }

    public function destroy(ExpenseListing $expenseList, Expense $expense): RedirectResponse
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403, 'Forbidden');
        }

        $expense->delete();
        return redirect()->route('expense-listings.index')->with('success', 'Expense deleted successfully.');
    }

    public function currentMonth(): JsonResponse
    {
        return $this->currentMonthExpenses();
    }
}
