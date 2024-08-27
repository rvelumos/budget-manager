<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();\
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }

    /** @test */
    public function expect_an_admin_cannot_see_normal_user_expenses()
    {

        $expense = Expense::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->adminUser)->get(route('expenses.show', $expense));

        $response->assertStatus(403);
    }

    /** @test */
    public function expect_a_expense_name_can_only_added_once()
    {

        $expense = Expense::factory()->create(['name' => 'Insurance']);

        $response = $this->post(route('expense.store'), [
            'name' => 'Insurance',
            'description' => 'This should fail',
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(1, Expense::where('name', 'Insurance')->count());
    }

    public function expect_expense_amount_can_only_be_numeric_and_not_negative()
        {

            $this->actingAs($this->user1);

            $response = $this->post(route('expenses.store'), [
                'amount' => 100,
                'category_id' => 1,
                'date' => now()->toDateString(),
                'description' => 'Test Expense',
            ]);

            $response->assertRedirect(route('expenses.index'));

            $response = $this->post(route('expenses.store'), [
                'amount' => -50,
                'category_id' => 1,
                'date' => now()->toDateString(),
                'description' => 'Negative Expense',
            ]);

            $response->assertSessionHasErrors('amount');

            $response = $this->post(route('expenses.store'), [
                'amount' => 'Blablabla',
                'category_id' => 1,
                'date' => now()->toDateString(),
                'description' => 'Non-Numeric Expense',
            ]);

            $response->assertSessionHasErrors('amount');
        }

    /**
     * Test
     */
    public function expect_user_cannot_delete_another_users_expense()
    {

       $expense = Expense::factory()->create(['user_id' => $this->user1->id]);

       $this->actingAs($this->user2);

       $response = $this->delete(route('expenses.destroy', $expense));

       $response->assertStatus(403);

       $this->assertDatabaseHas('expenses', ['id' => $expense->id]);
    }

    /**
     * Test
     */
    public function expect_user_can_delete_their_own_expense()
    {

       $expense = Expense::factory()->create([
           'user_id' => $this->user1->id,
       ]);

       $response = $this->delete(route('expenses.destroy', $expense));

       $response->assertRedirect(route('expenses.index'));

       $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }
}
