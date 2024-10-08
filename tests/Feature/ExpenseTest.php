<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use App\Models\ExpenseListing;

class ExpenseTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->category = Category::factory()->create(['id' => 1, 'type' => 'expense']);

        $this->expenseList = ExpenseListing::factory()->create(['user_id' => $this->user1->id]);
        $this->expense = Expense::factory()->create([
            'category_id' => $this->category->id,
            'expense_list_id' => $this->expenseList->id,
            'user_id' => $this->user1->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_a_expense_name_can_only_added_once_to_an_expense_listing(): void
    {

        $response = $this->actingAs($this->user1)->post(route('expense-lists.expenses.store', $this->expenseList), [
            'name' => 'Insurance',
            'description' => 'This should fail',
            'amount' => 100,
            'category_id' => 1,
            'date' => now(),
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(1, Expense::where('name', 'Insurance')->where('expense_list_id', $this->expenseList->id)->count());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_expense_amount_can_only_be_numeric_and_not_negative(): void
    {

        $this->actingAs($this->user1);

        $response = $this->post(route('expense-lists.expenses.store', $this->expenseList->id), [
            'name' => 'Valid Expense',
            'amount' => 100,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Test Expense',
            'expense_list_id' => $this->expenseList->id,
        ]);

        $response->assertRedirect(route('expense-lists.expenses.index', $this->expenseList->id));

        $response = $this->post(route('expense-lists.expenses.store', $this->expenseList->id), [
            'name' => 'Negative Expense',
            'amount' => -50,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Negative Expense',
            'expense_list_id' => $this->expenseList->id,
        ]);

        $response->assertSessionHasErrors('amount');

        $response = $this->post(route('expense-lists.expenses.store', $this->expenseList->id), [
            'name' => 'Non-Numeric Expense',
            'amount' => 'Blablabla',
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Non-Numeric Expense',
            'expense_list_id' => $this->expenseList->id,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_user_cannot_delete_another_users_expense(): void
    {

       $this->actingAs($this->user2);

       $response = $this->delete(route('expense-lists.expenses.destroy', [$this->expenseList, $this->expense]));

       $response->assertStatus(403);

       $this->assertDatabaseHas('expenses', ['id' => $this->expense->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_user_can_delete_their_own_expense(): void
    {

       $this->actingAs($this->user1);

       $response = $this->delete(route('expense-lists.expenses.destroy', [$this->expenseList, $this->expense]));

       $response->assertRedirect(route('expense-lists.expenses.index', $this->expenseList->id));

       $this->assertDatabaseMissing('expenses', ['id' => $this->expense->id]);
    }
}
