<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use App\Models\ExpenseListing;

class ExpenseTest extends TestCase
{

    use FastRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->category = Category::factory()->create(['id' => 1, 'type' => 'expense']);

        $this->expenseListing = ExpenseListing::factory()->create(['user_id' => $this->user1->id]);
        $this->expense = Expense::factory()->create([
            'category_id' => $this->category->id,
            'expense_listing_id' => $this->expenseListing->id,
            'user_id' => $this->user1->id,
        ]);
    }

    #[Test]
    public function expect_expense_amount_can_only_be_numeric_and_not_negative(): void
    {

        $this->actingAs($this->user1);

        $response = $this->post(route('expenses.store', $this->expenseListing), [
            'name' => 'Valid Expense',
            'amount' => 100,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Test Expense',
            'expense_listing_id' => $this->expenseListing->id,
        ]);

        $response->assertRedirect(route('expenses.index', $this->expenseListing));

        $response = $this->post(route('expenses.store', $this->expenseListing), [
            'name' => 'Negative Expense',
            'amount' => -50,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Negative Expense',
            'expense_listing_id' => $this->expenseListing->id,
        ]);
        $response->assertSessionHasErrors('amount');

        $response = $this->post(route('expenses.store', $this->expenseListing), [
            'name' => 'Non-Numeric Expense',
            'amount' => 'Blablabla',
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Non-Numeric Expense',
            'expense_listing_id' => $this->expenseListing->id,
        ]);
        $response->assertSessionHasErrors('amount');
    }

    #[Test]
    public function expect_user_cannot_delete_another_users_expense(): void
    {

       $this->actingAs($this->user2);

       $response = $this->delete(route('expenses.destroy', [$this->expenseListing, $this->expense]));

       $response->assertStatus(403);

       $this->assertDatabaseHas('expenses', ['id' => $this->expense->id]);
    }

    #[Test]
    public function expect_user_can_delete_their_own_expense(): void
    {

       $this->actingAs($this->user1);

       $response = $this->delete(route('expenses.destroy', [$this->expenseListing, $this->expense]));

       $response->assertRedirect(route('expense-listings.index'));

       $this->assertDatabaseMissing('expenses', ['id' => $this->expense->id]);
    }
}
