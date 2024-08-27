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

    public function edit(ExpenseListing $ExpenseListing)
    {
        return view('expense-listings.edit', compact('ExpenseListing'));
    }

    public function update(Request $request, ExpenseListing $ExpenseListing)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $ExpenseListing->update(['name' => $request->name]);

        return redirect()->route('expense-listings.index')->with('success', 'Expense list updated successfully.');
    }

    public function destroy(ExpenseListing $ExpenseListing)
    {
        $ExpenseListing->delete();
        return redirect()->route('expense-listings.index')->with('success', 'Expense list deleted successfully.');
    }
}
