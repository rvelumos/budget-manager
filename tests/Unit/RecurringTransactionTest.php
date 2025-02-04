<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\RecurringTransaction;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;

class RecurringTransactionTest extends TestCase
{
    use FastRefreshDatabase;

    #[Test]
    public function expect_we_can_create_a_recurring_transaction(): void
    {
        $userId = User::factory()->create()->id;

        RecurringTransaction::factory()->create([
            'user_id' => $userId,
            'amount' => 1200.00,
            'frequency' => 'monthly',
            'start_date' => now(),
            'end_date' => null,
        ]);

        $this->assertDatabaseHas('recurring_transactions', [
            'user_id' => $userId,
            'amount' => 1200.00,
        ]);
    }

    #[Test]
    public function expect_we_can_calculate_the_next_occurrence(): void
    {
        $recurringTransaction = RecurringTransaction::factory()->create([
            'start_date' => now()->toDateString(),
            'frequency' => 'weekly',
        ]);

        $nextDate = $recurringTransaction->calculateNextOccurrence();

        $expectedDate = Carbon::parse($recurringTransaction->start_date)->addWeek()->format('Y-m-d');

        $this->assertEquals($expectedDate, $nextDate->format('Y-m-d'));
    }

    #[Test]
    public function expect_we_can_stop_recurring_transactions_after_end_date(): void
    {
        $recurringTransaction = RecurringTransaction::factory()->create([
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->subDay()->toDateString(),
            'frequency' => 'weekly',
        ]);

        $this->assertFalse($recurringTransaction->isActive());
    }
}
