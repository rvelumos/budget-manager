<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class BudgetTest extends TestCase
{
        use FastRefreshDatabase;

        protected $user;

        protected function setUp(): void
        {
            parent::setUp();

            $this->user = User::factory()->create();
            $this->actingAs($this->user);
        }

        #[Test]
        public function expect_user_can_visit_the_budget_index_page(): void
        {

            $this->get(route('budgets.index'))
                ->assertRedirect('login');

            $this->be($this->user)
                ->get(route('budgets.create'))
                ->assertStatus(200);
        }

        #[Test]
        public function expert_user_can_create_budget_item(): void
        {

            $response = $this->get(route('budgets.create'));

            $response->assertStatus(200);
            $response->assertViewIs('budgets.create');
        }

        #[Test]
        public function expect_user_can_store_a_new_budget(): void
        {

            $category = Category::factory()->create();

            $budgetData = [
                'amount' => 1000,
                'category_id' => $category->id,
                'period' => 'monthly',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
            ];

            $response = $this->post(route('budgets.store'), $budgetData);

            $response->assertRedirect(route('budgets.index'));
            $this->assertDatabaseHas('budgets', $budgetData);
        }

        #[Test]
        public function expect_user_can_visit_edit_budget_page(): void
        {

            $budget = Budget::factory()->create();

            $response = $this->get(route('budgets.edit', $budget));

            $response->assertStatus(200);
            $response->assertViewIs('budgets.edit');
            $response->assertViewHas('budget');
        }

        #[Test]
        public function expect_user_can_update_an_existing_budget(): void
        {

            $budget = Budget::factory()->create();

            $updatedData = [
                'amount' => 2000,
                'category_id' => $budget->category_id,
                'period' => 'weekly',
                'start_date' => '2025-02-01',
                'end_date' => '2025-12-31',
            ];

            $response = $this->put(route('budgets.update', $budget), $updatedData);

            $response->assertRedirect(route('budgets.index'));
            $this->assertDatabaseHas('budgets', $updatedData);
        }

        #[Test]
        public function expect_user_can_see_budget_details(): void
        {

            $budget = Budget::factory()->create();

            $response = $this->get(route('budgets.show', $budget));

            $response->assertStatus(200);
            $response->assertViewIs('budgets.show');
            $response->assertViewHas('budget', $budget);
        }

        #[Test]
        public function expect_user_can_delete_a_budget(): void
        {

            $budget = Budget::factory()->create();

            $response = $this->delete(route('budgets.destroy', $budget));

            $response->assertRedirect(route('budgets.index'));
            $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
        }
}
