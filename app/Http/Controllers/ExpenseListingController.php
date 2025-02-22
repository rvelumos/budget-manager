<?php

namespace App\Http\Controllers;

use App\Models\ExpenseListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExpenseListingController extends Controller
{
    use AuthorizesRequests;

    public function index(): View|Factory|Application
    {
        $listings = ExpenseListing::where('user_id', auth()->id())->with('expenses')->get();

        return view('expense-listings.index', compact('listings'));
    }

    public function show(ExpenseListing $expenseListing): View
    {

        if ($expenseListing->user_id !== auth()->id() || auth()->user()->isAdmin()) {
            abort(403, __('Unauthorized access.'));
        }

        $expenses = $expenseListing->expenses()->with('category')->get();

        return view('expense-listings.show', compact('expenseListing', 'expenses'));
    }

    public function create(ExpenseListing $expenseListing): Application|Factory|View
    {
        return view('expenses.create', compact('expenseListing'));
    }

    public function store(Request $request): RedirectResponse
    {
        $userExpenseCount = ExpenseListing::where('user_id', auth()->id())->count();

        if ($userExpenseCount >= 10) {
            return redirect()->back()->withErrors([
                'limit' => __('messages.limit_reached_expense'),
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ExpenseListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('expense-listings.index')->with('success', __('messages.expense_listing_created'));
    }

    public function edit(ExpenseListing $expenseListing): View|Factory|Application
    {
        return view('expense-listings.edit', compact('expenseListing'));
    }

    public function update(Request $request, ExpenseListing $expenseListing): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $expenseListing->update($request->only(['name', 'description']));

        return redirect()->route('expense-listings.index')->with('success', __('messages.expense_listing_updated'));
    }

    public function destroy(ExpenseListing $expenseListing): JsonResponse|RedirectResponse
    {
        try {
            $this->authorize('delete', $expenseListing);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $expenseListing->delete();

        return redirect()->route('expense-listings.index')
            ->with('success', __('messages.expense_listing_deleted'));
    }
}
