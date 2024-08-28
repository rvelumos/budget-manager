<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ExpenseListing;
use App\Models\Expense;
use App\Models\User;


class ExpenseListingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();

        $this->adminUser = User::factory()->create(['is_admin' => true]);

        $this->expenseList = ExpenseListing::factory()->create(['user_id' => $this->user1->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_only_authenticated_user_can_access_listing_page(): void
    {
        $this->get('/expense-listings')
            ->assertRedirect('login');

        $this->be($this->user1)
            ->get("/expense-listings")
            ->assertStatus(200);

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_an_admin_cannot_see_normal_user_expense_listing(): void
    {

        $expense = Expense::factory()->create(['user_id' => $this->user1->id]);

        $response = $this->actingAs($this->adminUser)->get(route('expense-listings.show', $expense));

        $response->assertStatus(403);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_a_user_cannot_create_more_than_10_expense_listings(): void
    {

        ExpenseListing::factory()->count(10)->create(['user_id' => $this->user1->id]);

        $response = $this->actingAs($this->user1)->post(route('expense-lists.store'), [
            'name' => 'New Expense List'
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseCount('expenses', 10);
    }
}
