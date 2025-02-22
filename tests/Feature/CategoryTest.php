<?php

namespace Tests\Feature;

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
            ->get("/admin/categories")
            ->assertStatus(403);
    }

    #[Test]
    public function expect_a_category_name_can_only_added_once(): void
    {

        Category::factory()->create(['name' => 'Groceries']);

        $this->post(route('admin.categories.post'), [
            'name' => 'Groceries',
            'description' => 'This should fail',
        ]);

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
                            ->post(route('admin.categories.post'), $data);

            $response->assertStatus(302);
            $this->assertDatabaseHas('categories', [
                'name' => 'Category',
                'description' => 'Category description',
            ]);
    }
}
