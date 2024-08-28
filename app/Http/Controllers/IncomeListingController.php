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

    public function edit(IncomeListing $IncomeListing)
    {
        return view('income-listings.edit', compact('IncomeListing'));
    }

    public function update(Request $request, IncomeListing $IncomeListing)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $IncomeListing->update(['name' => $request->name]);

        return redirect()->route('income-listings.index')->with('success', 'Income list updated successfully.');
    }

    public function destroy(IncomeListing $IncomeListing)
    {
        $IncomeListing->delete();
        return redirect()->route('income-listings.index')->with('success', 'Income list deleted successfully.');
    }
}
