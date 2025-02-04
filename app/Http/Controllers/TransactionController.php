<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\RecurringTransaction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionController extends Controller
{
    public function index(): View|Factory|Application
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->get()
            ->map(function ($transaction) {
                $transaction->type = 'regular';
                return $transaction;
            });

        $recurringTransactions = RecurringTransaction::where('user_id', auth()->id())
            ->get()
            ->map(function ($recurring) {
                $recurring->type = 'recurring';
                return $recurring;
            });

        $allTransactions = $transactions->merge($recurringTransactions);

        return view('transactions.index', compact('allTransactions'));
    }

    public function create(): View|Factory|Application
    {
        return view('transactions.create');
    }

    public function store(Request $request): RedirectResponse
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
                'type' => 'required|string',
                'date' => 'required|date',
            ]);

            Transaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'date' => $request->date,
                'type' => $request->type,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    public function edit($id, $type): View|Factory|Application
    {
        if ($type === 'recurring') {
            $transaction = RecurringTransaction::findOrFail($id);
        } else {
            $transaction = Transaction::findOrFail($id);
        }

        return view('transactions.edit', compact('transaction', 'type'));
    }

    public function update(Request $request, $id, $type='regular'): RedirectResponse
    {

        if ($type == 'recurring') {
            $transaction = RecurringTransaction::findOrFail($id);

            if ($transaction->user_id !== auth()->id()) {
                abort(403, 'Forbidden');
            }

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

            if ($transaction->user_id !== auth()->id()) {
                abort(403, 'Forbidden');
            }

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

    public function destroy($id, Request $request): RedirectResponse
    {
        $type = $request->input('type', 'regular');

        if ($type === 'recurring') {
            $transaction = RecurringTransaction::findOrFail($id);
        } else {
            $transaction = Transaction::findOrFail($id);
        }

        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this transaction.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
