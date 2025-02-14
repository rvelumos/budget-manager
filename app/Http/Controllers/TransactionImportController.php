<?php

namespace App\Http\Controllers;

use App\Imports\TransactionsImport;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionImportController
{
    public function showImportForm(): View|Factory|Application
    {
        return view('transactions.import');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv,txt|max:2048']);

        Excel::import(new TransactionsImport, $request->file('file'));

        return redirect()->back()->with('success', __('messages.transactions_imported'));
    }
}
