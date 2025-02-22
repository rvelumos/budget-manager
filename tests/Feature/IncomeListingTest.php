<?php

namespace Tests\Feature;

use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\IncomeListing;
use App\Models\Income;
use App\Models\User;

class IncomeListingTest extends TestCase
{
    use FastRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => true]);

        $this->incomeList = IncomeListing::factory()->create(['user_id' => $this->user1->id]);
    }

    #[Test]
    public function expect_only_authenticated_user_can_access_listing_page(): void
    {
        $this->get(route('income-listings.index'))
            ->assertStatus(302);

        $this->be($this->user1)
            ->get(route('income-listings.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function expect_an_admin_cannot_see_normal_user_income_listing(): void
    {

        $incomeListing = IncomeListing::factory()->create(['user_id' => $this->user1->id]);

        Income::factory()->create([
            'user_id' => $this->user1->id,
            'income_list_id' => $incomeListing->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('income-listings.show', $incomeListing->id));

        $response->assertStatus(403);
    }

    #[Test]
    public function expect_a_user_cannot_create_more_than_5_income_listings(): void
    {

        $this->actingAs($this->user1);

        IncomeListing::factory()->count(4)->create(['user_id' => $this->user1->id]);

        $response = $this->post(route('income-listings.store'), [
            'name' => 'Extra Income Listing',
        ]);

        $response->assertSessionHasErrors(['limit' => __('You cannot create more than 5 income listings.')]);

        $this->assertCount(
            5,
            IncomeListing::where('user_id', $this->user1->id)->get(),
            'The user should not have more than 5 income listings.'
        );
    }
}
