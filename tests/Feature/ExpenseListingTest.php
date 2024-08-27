<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseListingTest extends TestCase
{

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
