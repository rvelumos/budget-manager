<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function expect_user_can_visit_forecast_index_page()
    {
        $forecasts = Forecast::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('forecasts.index'));

        $response->assertStatus(200)
                 ->assertViewIs('forecast.index')
                 ->assertSee('Forecasts');

        foreach ($forecasts as $forecast) {
            $response->assertSee($forecast->name);
        }
    }

    #[Test]
    public function expect_user_can_visit_create_page()
    {
        $response = $this->get(route('forecasts.create'));

        $response->assertStatus(200)
                 ->assertViewIs('forecast.create')
                 ->assertSee('Create Forecast');
    }

    #[Test]
    public function expect_user_can_store_a_new_forecast()
    {
        $data = [
            'name' => 'My Forecast',
            'description' => 'This is a test forecast',
            'amount' => 1500,
            'date' => now()->format('Y-m-d'),
        ];

        $response = $this->post(route('forecasts.store'), $data);

        $response->assertRedirect(route('forecasts.index'))
                 ->assertSessionHas('success', 'Forecast created successfully.');

        $this->assertDatabaseHas('forecasts', $data);
    }

    #[Test]
    public function expect_user_can_visit_the_forecast_edit_page()
    {
        $forecast = Forecast::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('forecasts.edit', $forecast));

        $response->assertStatus(200)
                 ->assertViewIs('forecast.edit')
                 ->assertSee('Edit Forecast')
                 ->assertSee($forecast->name);
    }

    #[Test]
    public function expect_user_can_update_an_existing_forecast()
    {
        $forecast = Forecast::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'name' => 'Updated Forecast',
            'description' => 'Updated description',
            'amount' => 2000,
            'date' => now()->addDays(10)->format('Y-m-d'),
        ];

        $response = $this->put(route('forecasts.update', $forecast), $data);

        $response->assertRedirect(route('forecasts.index'))
                 ->assertSessionHas('success', 'Forecast updated successfully.');

        $this->assertDatabaseHas('forecasts', $data);
    }

    #[Test]
    public function expect_user_can_delete_his_own_forecast()
    {
        $forecast = Forecast::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('forecasts.destroy', $forecast));

        $response->assertRedirect(route('forecasts.index'))
                 ->assertSessionHas('success', 'Forecast deleted successfully.');

        $this->assertDatabaseMissing('forecasts', ['id' => $forecast->id]);
    }

    #[Test]
    public function expect_unauthorized_users_cannot_manage_forecasts()
    {
        $forecast = Forecast::factory()->create();

        $response = $this->get(route('forecasts.edit', $forecast));
        $response->assertForbidden();

        $response = $this->put(route('forecasts.update', $forecast), [
            'name' => 'Should Not Work',
        ]);
        $response->assertForbidden();

        $response = $this->delete(route('forecasts.destroy', $forecast));
        $response->assertForbidden();
    }
}
