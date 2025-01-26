<?php

namespace Tests\Feature;

use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use FastRefreshDatabase;

    protected $user;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    #[Test]
    public function expect_authenticated_user_can_access_account_page(): void
    {
        $this->get('/account/settings')
            ->assertRedirect('login');

        $this->be($this->user)
            ->get("/account/settings")
            ->assertStatus(200);

    }

    #[Test]
    public function expect_authenticated_user_cannot_access_admin_page(): void
    {

        $this->be($this->user)
            ->get("/admin")
            ->assertStatus(403);

        $this->be($this->admin)
            ->get("/admin")
            ->assertStatus(200);
    }
}
