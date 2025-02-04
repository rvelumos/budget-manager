<?php

namespace Tests\Feature;

use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use App\Models\IncomeListing;
use App\Models\Category;
use App\Models\Income;
use App\Models\User;

class IncomeTest extends TestCase
{

    use FastRefreshDatabase;

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
            'income_listing_id' => $this->incomeListing->id,
            'user_id' => $this->user1->id,
        ]);
    }

    #[Test]
    public function expect_income_amount_can_only_be_numeric_and_not_negative(): void
    {

        $this->actingAs($this->user1);

        $response = $this->post(route('incomes.store', $this->incomeListing->id), [
            'name' => 'Valid income',
            'amount' => 2100,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Test income',
            'income_listing_id' => $this->incomeListing->id,
        ]);

        $response->assertRedirect(route('incomes.index', $this->incomeListing->id));

        $response = $this->post(route('incomes.store', $this->incomeListing->id), [
            'name' => 'Negative income',
            'amount' => -50,
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Negative income',
            'income_listing_id' => $this->incomeListing->id,
        ]);

        $response->assertSessionHasErrors('amount');

        $response = $this->post(route('incomes.store', $this->incomeListing->id), [
            'name' => 'Non-Numeric income',
            'amount' => 'Blablabla',
            'category_id' => 1,
            'date' => now()->toDateString(),
            'description' => 'Non-Numeric income',
            'income_listing_id' => $this->incomeListing->id,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    #[Test]
    public function expect_user_cannot_delete_another_users_income(): void
    {

        $income = Income::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user2);

        $response = $this->delete(route('incomes.destroy', $income));

        $response->assertStatus(403);
    }

    #[Test]
    public function expect_user_can_delete_their_own_income(): void
    {

       $this->actingAs($this->user1);

       $response = $this->delete(route('incomes.destroy', [$this->incomeListing, $this->income]));
       $response->assertRedirect(route('incomes.index'));

       $this->assertDatabaseMissing('incomes', ['id' => $this->income->id]);
    }
}
