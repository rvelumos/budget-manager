<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\ExpenseList;
use Illuminate\Http\Request;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(ExpenseList $expenseList)
    {
        $expenses = $expenseList->expenses()->with('category')->get();

        return view('expenses.index', compact('expenseList', 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create(ExpenseList $expenseList)
    {
        return view('expenses.create', compact('expenseList'));
    }

    public function store(Request $request, ExpenseList $expenseList)
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

    public function show(ExpenseList $expenseList, Expense $expense)
    {
        return view('expenses.show', compact('expenseList', 'expense'));
    }

    public function edit(ExpenseList $expenseList, Expense $expense)
    {
        return view('expenses.edit', compact('expenseList', 'expense'));
    }

    public function update(Request $request, ExpenseList $expenseList, Expense $expense)
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

    public function destroy(ExpenseList $expenseList, Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expense-lists.expenses.index', $expenseList)->with('success', 'Expense deleted successfully.');
    }
}
