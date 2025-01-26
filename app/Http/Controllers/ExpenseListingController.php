<?php

namespace App\Http\Controllers;

use App\Models\ExpenseListing;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExpenseListingController extends Controller
{
    public function index(): View|Factory|Application
    {
        $ExpenseListings = ExpenseListing::where('user_id', auth()->id())->get();
        return view('expense-listings.index', compact('ExpenseListings'));
    }

    public function create(): View|Factory|Application
    {
        return view('expense-listings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);

        ExpenseListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expense-listings.index')->with('success', 'Expense list created successfully.');
    }

    public function edit(ExpenseListing $expenseListing): View|Factory|Application
    {
        return view('expenselistings.edit', compact('expenseListing'));
    }

    public function update(Request $request, ExpenseListing $expenseListing): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $expenseListing->update($request->only(['name', 'description']));

        return redirect()->route('expenselistings.index')->with('success', __('messages.expense_listing_updated'));
    }

    public function destroy(ExpenseListing $ExpenseListing): RedirectResponse
    {
        $ExpenseListing->delete();
        return redirect()->route('expense-listings.index')->with('success', 'Expense list deleted successfully.');
    }
}
