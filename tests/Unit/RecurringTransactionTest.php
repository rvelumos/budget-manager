<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use App\Models\RecurringTransaction;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;

class RecurringTransactionTest extends TestCase
{
    use FastRefreshDatabase;

    #[Test]
    public function expect_we_can_create_a_recurring_transaction()
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
    public function expect_we_can_calculate_the_next_occurrence()
    {
        $recurringTransaction = RecurringTransaction::factory()->create([
            'frequency' => 'weekly',
            'start_date' => now()->subWeek(),
        ]);

        $nextDate = $recurringTransaction->calculateNextOccurrence();

        $this->assertEquals(now()->addWeek()->format('Y-m-d'), $nextDate->format('Y-m-d'));
    }

    #[Test]
    public function expect_we_can_stop_recurring_transactions_after_end_date()
    {
        $recurringTransaction = RecurringTransaction::factory()->create([
            'end_date' => now()->subDay(),
        ]);

        $this->assertFalse($recurringTransaction->isActive());
    }
}
