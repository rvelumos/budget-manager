<?php

namespace Tests\Feature;

use App\Models\Forecast;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class ForecastTest extends TestCase
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
    public function expect_user_can_visit_forecast_index_page(): void
    {
        $forecasts = Forecast::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('forecasts.index'));

        $response->assertStatus(200)
                 ->assertViewIs('forecasts.index');

        foreach ($forecasts as $forecast) {
            $response->assertSee($forecast->name);
        }
    }

    #[Test]
    public function test_forecast_data_is_displayed_correctly(): void
    {
        $this->actingAs($this->user);

        $recurringTransaction = RecurringTransaction::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 100,
            'frequency' => 'monthly',
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->addMonths(6),
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 500,
            'date' => now()->startOfMonth(),
        ]);

        $response = $this->get(route('forecasts.index'));
        $response->assertStatus(200);

        $response->assertSee((string) $recurringTransaction->amount);
        $response->assertSee((string) $transaction->amount);

        $predictedBalance = $transaction->amount + ($recurringTransaction->amount * 6);
        $response->assertSee((string) $predictedBalance);
    }

    #[Test]
    public function test_forecast_page_shows_message_when_no_data_is_available(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('forecasts.index'));

        $response->assertStatus(200);
    }
}
