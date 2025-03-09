<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;

class TransactionsImport implements ToModel
{
    public function model(array $row): Transaction
    {
        return new Transaction([
            'user_id'    => auth()->id(),
            'date'       => $row[0],
            'amount'     => $row[1],
            'category'   => $row[2],
            'description' => $row[3],
        ]);
    }
}
