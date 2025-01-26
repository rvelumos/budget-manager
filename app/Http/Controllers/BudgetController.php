<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{

    public function index(): View|Factory|Application
    {
        $budgets = Budget::where('user_id', Auth::id())->with('category')->get();
        return view('budgets.index', compact('budgets'));
    }

    public function create(): View|Factory|Application
    {
        $categories = Category::all();
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'period' => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'period' => $request->period,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    public function show(Budget $budget): View|Factory|Application
    {
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget): View|Factory|Application
    {

        $categories = Category::all();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget): RedirectResponse
    {

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'period' => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $budget->update([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'period' => $request->period,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }
}
