<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_only_admin_user_can_view_category_page()
    {

        $this->be($this->user)
            ->get("/admin/category")
            ->assertStatus(403);

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function expect_a_category_name_can_only_added_once()
    {

        $category = Category::factory()->create(['name' => 'Groceries']);

        $response = $this->post(route('category.store'), [
            'name' => 'Groceries',
            'description' => 'This should fail',
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(1, Category::where('name', 'Groceries')->count());

    }

    #[\PHPUnit\Framework\Attributes\Test]
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
