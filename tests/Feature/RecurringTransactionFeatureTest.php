<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use App\Models\RecurringTransaction;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;

class RecurringTransactionFeatureTest extends TestCase
{
    use FastRefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function expect_an_user_can_create_a_recurring_transaction(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('recurring-transactions.store'), [
            'name' => 'Video Streaming service',
            'amount' => 12.00,
            'frequency' => 'monthly',
            'start_date' => now(),
            'end_date' => now()->addYear(),
        ]);

        $response->assertRedirect(route('recurring-transactions.index'));
        $this->assertDatabaseHas('recurring_transactions', [
            'name' => 'Video Streaming service',
            'amount' => 12.00,
        ]);
    }

    #[Test]
    public function expect_an_user_can_update_a_recurring_transaction(): void
    {
        $transaction = RecurringTransaction::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $response = $this->put(route('recurring-transactions.update', $transaction), [
            'name' => 'Updated Transaction',
            'amount' => 75.00,
            'frequency' => 'weekly',
        ]);

        $response->assertRedirect(route('recurring-transactions.index'));
        $this->assertDatabaseHas('recurring_transactions', [
            'id' => $transaction->id,
            'name' => 'Updated Transaction',
            'amount' => 75.00,
        ]);
    }

    #[Test]
    public function expect_user_can_delete_a_recurring_transaction(): void
    {
        $transaction = RecurringTransaction::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $response = $this->delete(route('recurring-transactions.destroy', $transaction));

        $response->assertRedirect(route('recurring-transactions.index'));
        $this->assertDatabaseMissing('recurring_transactions', [
            'id' => $transaction->id,
        ]);
    }

    #[Test]
    public function expect_unauthorized_user_cannot_access_recurring_transactions(): void
    {
        RecurringTransaction::factory()->create();

        $response = $this->get(route('recurring-transactions.index'));

        $response->assertRedirect(route('login'));
    }
}
