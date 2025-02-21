<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use App\Models\IncomeListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{

    use AuthorizesRequests;

    public function index(): View|Factory|Application
    {
        $incomes = Income::where('user_id', Auth::id())->with('category')->get();
        return view('income.index', compact('incomes'));
    }

    public function create(): View|Factory|Application
    {
        $categories = Category::where('type', 'income')->get();
        return view('income.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Income::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function edit(Income $income): View|Factory|Application
    {
        try {
            $this->authorize('update', $income);
        } catch (AuthorizationException $e) {

        }
        $categories = Category::where('type', 'income')->get();
        return view('income.edit', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income): RedirectResponse
    {
        try {
            $this->authorize('update', $income);
        } catch (AuthorizationException $e) {

        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $income->update([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(IncomeListing $incomeList, Income $income): JsonResponse|RedirectResponse
    {

        try {
            $this->authorize('delete', $income);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $income->delete();

        return redirect()->route('income-listings.index', [$incomeList, $income])
            ->with('success', 'Income deleted successfully.');
    }
}
