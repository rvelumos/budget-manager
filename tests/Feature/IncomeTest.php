<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\IncomeListing;
use App\Models\Category;
use App\Models\Income;
use App\Models\User;

class IncomeTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->category = Category::factory()->create(['id' => 1, 'type' => 'expense']);

        $this->incomeListing = IncomeListing::factory()->create(['user_id' => $this->user1->id]);
        $this->income = Income::factory()->create([
            'category_id' => $this->category->id,
            'income_list_id' => $this->incomeListing->id,
            'user_id' => $this->user1->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_income_amount_can_only_be_numeric_and_not_negative(): void
    {

        $this->actingAs($this->user1);

        $response = $this->post(route('income-lists.incomes.store', $this->incomeListing->id), [
            'name' => 'Valid income',
            'amount' => 2100,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Test income',
            'income_list_id' => $this->incomeListing->id,
        ]);

        $response->assertRedirect(route('income-lists.incomes.index', $this->incomeListing->id));

        $response = $this->post(route('income-lists.incomes.store', $this->incomeListing->id), [
            'name' => 'Negative income',
            'amount' => -50,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Negative income',
            'income_list_id' => $this->incomeListing->id,
        ]);

        $response->assertSessionHasErrors('amount');

        $response = $this->post(route('income-lists.incomes.store', $this->incomeListing->id), [
            'name' => 'Non-Numeric income',
            'amount' => 'Blablabla',
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Non-Numeric income',
            'income_list_id' => $this->incomeListing->id,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_user_cannot_delete_another_users_income(): void
    {

       $this->actingAs($this->user2);

       $response = $this->delete(route('income-lists.incomes.destroy', [$this->incomeListing, $this->income]));

       $response->assertStatus(403);

       $this->assertDatabaseHas('incomes', ['id' => $this->income->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_user_can_delete_their_own_income(): void
    {

       $this->actingAs($this->user1);

       $response = $this->delete(route('income-lists.incomes.destroy', [$this->incomeListing, $this->income]));

       $response->assertRedirect(route('income-lists.incomes.index', $this->incomeListing->id));

       $this->assertDatabaseMissing('incomes', ['id' => $this->income->id]);
    }
}
