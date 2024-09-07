<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseListingingController extends Controller
{
    public function index()
    {
        $ExpenseListings = ExpenseListing::where('user_id', auth()->id())->get();
        return view('expense-listings.index', compact('ExpenseListings'));
    }

    public function create()
    {
        return view('expense-listings.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        ExpenseListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expense-listings.index')->with('success', 'Expense list created successfully.');
    }

    public function show(ExpenseListing $ExpenseListing)
    {
        return view('expense-listings.show', compact('ExpenseListing'));
    }

    public function edit(ExpenseListing $expenseListing)
    {
        return view('expenselistings.edit', compact('expenseListing'));
    }

    public function update(Request $request, ExpenseListing $expenseListing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $expenseListing->update($request->only(['name', 'description']));

        return redirect()->route('expenselistings.index')->with('success', __('messages.expense_listing_updated'));
    }

    public function destroy(ExpenseListing $ExpenseListing)
    {
        $ExpenseListing->delete();
        return redirect()->route('expense-listings.index')->with('success', 'Expense list deleted successfully.');
    }
}
