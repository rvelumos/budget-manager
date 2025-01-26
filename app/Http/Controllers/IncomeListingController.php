<?php

namespace App\Http\Controllers;

use App\Models\IncomeListing;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IncomeListingController extends Controller
{
    public function index(): View|Factory|Application
    {
        $IncomeListings = IncomeListing::where('user_id', auth()->id())->get();
        return view('income-listings.index', compact('IncomeListings'));
    }

    public function create(): View|Factory|Application
    {
        return view('income-listings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);

        IncomeListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('income-listings.index')->with('success', 'Income list created successfully.');
    }

    public function edit(IncomeListing $incomeListing): View|Factory|Application
    {
        return view('incomelistings.edit', compact('incomeListing'));
    }

    public function update(Request $request, IncomeListing $incomeListing): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $incomeListing->update($request->only(['name', 'description']));

        return redirect()->route('incomelistings.index')->with('success', __('messages.income_listing_updated'));
    }

    public function destroy(IncomeListing $IncomeListing): RedirectResponse
    {
        $IncomeListing->delete();
        return redirect()->route('income-listings.index')->with('success', 'Income list deleted successfully.');
    }
}
