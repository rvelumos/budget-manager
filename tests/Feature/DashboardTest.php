<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;

use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{

    use FastRefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function expect_a_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function expect_an_authenticated_user_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertSee(__('dashboard.title'));
    }

    #[Test]
    public function expect_dashboard_shows_correct_income_expense_and_savings_from_current_user(): void
    {

        Income::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 5000,
            'date' => now(),
        ]);

        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 2000,
            'date' => now(),
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertSee('€ 5,000.00');
        $response->assertSee('€ 2,000.00');
        $response->assertSee('€ 3,000.00');
    }

    #[Test]
    public function expect_dashboard_displays_expenses_by_category(): void
    {
        $category = Category::factory()->create(['name' => 'Food']);

        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 150,
            'date' => now(),
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertSee('Food');
        $response->assertSee('€ 150.00');
    }
}
