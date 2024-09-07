<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeListingController extends Controller
{
    public function index()
    {
        $IncomeListings = IncomeListing::where('user_id', auth()->id())->get();
        return view('income-listings.index', compact('IncomeListings'));
    }

    public function create()
    {
        return view('income-listings.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        IncomeListing::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('income-listings.index')->with('success', 'Income list created successfully.');
    }

    public function show(IncomeListing $IncomeListing)
    {
        return view('income-listings.show', compact('IncomeListing'));
    }

    public function edit(IncomeListing $incomeListing)
    {
        return view('incomelistings.edit', compact('incomeListing'));
    }

    public function update(Request $request, IncomeListing $incomeListing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $incomeListing->update($request->only(['name', 'description']));

        return redirect()->route('incomelistings.index')->with('success', __('messages.income_listing_updated'));
    }

    public function destroy(IncomeListing $IncomeListing)
    {
        $IncomeListing->delete();
        return redirect()->route('income-listings.index')->with('success', 'Income list deleted successfully.');
    }
}
