<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\ExpenseListing;
use Illuminate\Http\Request;
use App\Traits\HasCurrentMonthData;


class ExpenseController extends Controller
{
    use HasCurrentMonthData;
    /**
     * Display a listing of the resource.
     */
     public function index(ExpenseListing $expenseList)
    {
        $expenses = $expenseList->expenses()->with('category')->get();

        return view('expenses.index', compact('expenseList', 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create(ExpenseListing $expenseList)
    {
        return view('expenses.create', compact('expenseList'));
    }

    public function store(Request $request, ExpenseListing $expenseList)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expenseList->expenses()->create([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expense-lists.expenses.index', $expenseList)->with('success', 'Expense added successfully.');
    }

    public function show(ExpenseListing $expenseList, Expense $expense)
    {
        return view('expenses.show', compact('expenseList', 'expense'));
    }

    public function edit(ExpenseListing $expenseList, Expense $expense)
    {
        return view('expenses.edit', compact('expenseList', 'expense'));
    }

    public function update(Request $request, ExpenseListing $expenseList, Expense $expense)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expense-lists.expenses.index', $expenseList)->with('success', 'Expense updated successfully.');
    }

    public function destroy(ExpenseListing $expenseList, Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expense-lists.expenses.index', $expenseList)->with('success', 'Expense deleted successfully.');
    }

    public function currentMonth()
    {
        return $this->currentMonthExpenses();
    }
}
