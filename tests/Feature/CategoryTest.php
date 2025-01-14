<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{

    use FastRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    #[Test]
    public function expect_only_admin_user_can_view_category_page(): void
    {

        $this->be($this->user)
            ->get("/admin/category")
            ->assertStatus(403);

    }

    #[Test]
    public function expect_a_category_name_can_only_added_once(): void
    {

        Category::factory()->create(['name' => 'Groceries']);

        $response = $this->post(route('category.store'), [
            'name' => 'Groceries',
            'description' => 'This should fail',
        ]);

        $response->assertSessionHasErrors('name');

        $this->assertEquals(1, Category::where('name', 'Groceries')->count());

    }

    #[Test]
    public function expect_an_admin_can_create_a_category(): void
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
