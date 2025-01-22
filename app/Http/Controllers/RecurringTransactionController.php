<?php

namespace App\Http\Controllers;

use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class RecurringTransactionController extends Controller
{
    public function index()
    {
        $recurringTransactions = RecurringTransaction::where('user_id', auth()->id())->get();
        return view('recurring-transactions.index', compact('recurringTransactions'));
    }

    public function create()
    {
        return view('recurring-transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'frequency' => 'required|string',
        ]);

        RecurringTransaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'start_date' => $request->start_date,
            'frequency' => $request->frequency,
        ]);

        return redirect()->route('recurring-transactions.index')->with('success', 'Recurring transaction created.');
    }

    public function edit(RecurringTransaction $recurringTransaction)
    {
        return view('recurring-transactions.edit', compact('recurringTransaction'));
    }

    public function update(Request $request, RecurringTransaction $recurringTransaction)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'frequency' => 'required|string',
        ]);

        $recurringTransaction->update($request->all());

        return redirect()->route('recurring-transactions.index')->with('success', 'Recurring transaction updated.');
    }

    public function destroy(RecurringTransaction $recurringTransaction)
    {
        $recurringTransaction->delete();
        return redirect()->route('recurring-transactions.index')->with('success', 'Recurring transaction deleted.');
    }
}
