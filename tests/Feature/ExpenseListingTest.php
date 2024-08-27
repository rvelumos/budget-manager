<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseListingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();

        $this->adminUser = User::factory()->create(['is_admin' => true]);

        $this->expenseList = ExpenseList::factory()->create(['user_id' => $this->user1->id]);
    }

    /** @test */
    public function expect_only_authenticated_user_can_access_listing_page()
    {
        $this->get('/expense-listings')
            ->assertRedirect('login');

        $this->be($this->user)
            ->get("/expense-listings")
            ->assertStatus(200);

    }

    /** @test */
    public function expect_an_admin_cannot_see_normal_user_expense_listing()
    {

        $expense = Expense::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->adminUser)->get(route('expense-listings.show', $expense));

        $response->assertStatus(403);
    }

    /** @test */
    public function expect_a_user_cannot_create_more_than_10_expense_listings()
    {

        ExpenseListing::factory()->count(10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('expense-lists.store'), [
            'name' => 'New Expense List'
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseCount('expenses', 10);
    }
}
