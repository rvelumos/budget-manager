<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RecurringTransaction extends Model
{
    use HasFactory;

    public function calculateNextOccurrence(): Carbon
    {
        $startDate = Carbon::parse($this->start_date);

        return match ($this->frequency) {
            'daily' => $startDate->copy()->addDay(),
            'weekly' => $startDate->copy()->addWeek(),
            'monthly' => $startDate->copy()->addMonth(),
            'yearly' => $startDate->copy()->addYear(),
            default => throw new \InvalidArgumentException('Invalid frequency type'),
        };
    }

    public function isActive(): bool
    {
        if (!$this->end_date) {
            return true;
        }

        return Carbon::parse($this->end_date)->isFuture();
    }
}
