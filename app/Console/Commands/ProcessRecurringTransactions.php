<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;

class ProcessRecurringTransactions extends Command
{
    protected $signature = 'transactions:process-recurring';
    protected $description = 'Generate transactions for recurring entries';

    public function handle(): void
    {
        $now = Carbon::now();

        RecurringTransaction::where('next_occurrence', '<=', $now)
            ->get()
            ->each(function ($recurringTransaction) {
                Transaction::create([
                    'user_id' => $recurringTransaction->user_id,
                    'title' => $recurringTransaction->title,
                    'amount' => $recurringTransaction->amount,
                    'type' => $recurringTransaction->type,
                    'date' => $recurringTransaction->next_occurrence,
                ]);

                $recurringTransaction->next_occurrence = $this->calculateNextOccurrence(
                    $recurringTransaction->next_occurrence,
                    $recurringTransaction->frequency
                );
                $recurringTransaction->save();
            });

        $this->info('Recurring transactions processed.');
    }

    protected function calculateNextOccurrence(Carbon $currentDate, string $frequency): Carbon
    {
        return match ($frequency) {
            'daily' => Carbon::parse($currentDate)->addDay(),
            'weekly' => Carbon::parse($currentDate)->addWeek(),
            'monthly' => Carbon::parse($currentDate)->addMonth(),
            'yearly' => Carbon::parse($currentDate)->addYear(),
            default => $currentDate,
        };
    }
}
