<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use FastRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[Test]
    public function expect_user_can_view_his_transactions()
    {
        $this->actingAs($this->user);

        Transaction::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('transactions.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function expect_user_can_create_a_transaction()
    {
        $this->actingAs($this->user);

        $category = Category::factory()->create();

        $data = [
            'amount' => 100.50,
            'type' => 'income',
            'category_id' => $category->id,
            'date' => now()->toDateString(),
            'description' => 'Test Transaction',
        ];

        $response = $this->post(route('transactions.store'), $data);

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseHas('transactions', array_merge($data, ['user_id' => $this->user->id]));
    }

    #[Test]
    public function expect_user_cannot_create_transaction_with_invalid_data()
    {
        $this->actingAs($this->user);

        $data = [
            'amount' => null,
            'type' => null,
            'category_id' => null,
            'date' => null,
        ];

        $response = $this->post(route('transactions.store'), $data);

        $response->assertSessionHasErrors(['amount', 'type', 'category_id', 'date']);
    }

    #[Test]
    public function expect_user_can_update_their_transaction()
    {
        $this->actingAs($this->user);

        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);

        $updatedData = [
            'amount' => 200.75,
            'description' => 'Updated Transaction',
        ];

        $response = $this->put(route('transactions.update', $transaction), $updatedData);

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseHas('transactions', array_merge($updatedData, ['id' => $transaction->id]));
    }

    #[Test]
    public function expect_user_cannot_update_others_transactions()
    {
        $this->actingAs($this->user);

        $otherUser = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $otherUser->id]);

        $updatedData = [
            'amount' => 200.75,
        ];

        $response = $this->put(route('transactions.update', $transaction), $updatedData);

        $response->assertStatus(403);
    }

    #[Test]
    public function expect_user_can_delete_their_transaction()
    {
        $this->actingAs($this->user);

        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transactions.index'));
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    #[Test]
    public function user_cannot_delete_others_transactions()
    {
        $this->actingAs($this->user);

        $otherUser = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertStatus(403);
    }
}
