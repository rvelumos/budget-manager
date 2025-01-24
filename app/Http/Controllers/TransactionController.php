<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        $recurringTransactions = RecurringTransaction::where('user_id', auth()->id())->get();

        return view('transactions.index', compact('transactions', 'recurringTransactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        if ($request->has('is_recurring')) {
            $request->validate([
                'amount' => 'required|numeric',
                'frequency' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);

            RecurringTransaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'frequency' => $request->frequency,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
            ]);
        } else {
            $request->validate([
                'amount' => 'required|numeric',
                'date' => 'required|date',
            ]);

            Transaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    public function edit($id, $type)
    {
        if ($type === 'recurring') {
            $transaction = RecurringTransaction::findOrFail($id);
        } else {
            $transaction = Transaction::findOrFail($id);
        }

        return view('transactions.edit', compact('transaction', 'type'));
    }

    public function update(Request $request, $id, $type)
    {
        if ($type === 'recurring') {
            $transaction = RecurringTransaction::findOrFail($id);

            $request->validate([
                'amount' => 'required|numeric',
                'frequency' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);

            $transaction->update([
                'amount' => $request->amount,
                'frequency' => $request->frequency,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
            ]);
        } else {
            $transaction = Transaction::findOrFail($id);

            $request->validate([
                'amount' => 'required|numeric',
                'date' => 'required|date',
            ]);

            $transaction->update([
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id, $type)
    {
        if ($type === 'recurring') {
            RecurringTransaction::findOrFail($id)->delete();
        } else {
            Transaction::findOrFail($id)->delete();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
