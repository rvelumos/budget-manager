<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    /** @test */
    public function expect_only_admin_user_can_view_category_page()
    {

        $this->be($this->user)
            ->get("/admin/category")
            ->assertStatus(403);

    }

    public function expect_an_admin_can_create_a_category()
        {

            $data = [
                'name' => 'Category',
                'description' => 'Category description',
            ];

            $response = $this->be($this->admin)
                            ->post(route('categories.store'), $data);

            $response->assertStatus(201);
            $this->assertDatabaseHas('categories', [
                'name' => 'New Category',
                'description' => 'This is a new category description',
            ]);
        }
}
