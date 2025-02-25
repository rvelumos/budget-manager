<?php

namespace App\Http\Controllers;

use App\Models\IncomeListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IncomeListingController extends Controller
{
    use AuthorizesRequests;

    public function index(): View|Factory|Application
    {
        $listings = IncomeListing::where('user_id', auth()->id())->with('incomes')->get();

        return view('income-listings.index', compact('listings'));
    }

    public function show(IncomeListing $incomeListing): View
    {

        if ($incomeListing->user_id !== auth()->id() || auth()->user()->isAdmin()) {
            abort(403, __('Unauthorized access.'));
        }

        $incomes = $incomeListing->incomes()->with('category')->get();

        return view('income-listings.show', compact('incomeListing', 'incomes'));
    }

    public function create(): View|Factory|Application
    {
        return view('income-listings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);

        $userIncomeCount = IncomeListing::where('user_id', auth()->id())->count();

        if ($userIncomeCount >= 5) {
            return redirect()->back()->withErrors([
                'limit' => __('messages.limit_reached_income'),
            ]);
        }

        IncomeListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('income-listings.index')->with('success', __('messages.income_listing_created'));
    }

    public function edit(IncomeListing $incomeListing): View|Factory|Application
    {
        return view('income-listings.edit', compact('incomeListing'));
    }

    public function update(Request $request, IncomeListing $incomeListing): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $incomeListing->update($request->only(['name', 'description']));

        return redirect()->route('income-listings.index')->with('success', __('messages.income_listing_updated'));
    }

    public function destroy(IncomeListing $IncomeListing): RedirectResponse|JsonResponse
    {
        try {
            $this->authorize('delete', $IncomeListing);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return redirect()->route('income-listings.index')->with('success', __('messages.income_listing_deleted'));
    }
}
