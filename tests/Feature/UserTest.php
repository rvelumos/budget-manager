<?php

namespace Tests\Feature;

use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->get('/account')
            ->assertRedirect('login');

        $this->be($this->user)
            ->get("/account")
            ->assertStatus(200);

    }

    #[Test]
    public function expect_authenticated_user_cannot_access_admin_page(): void
    {

        $this->be($this->user)
            ->get("/admin")
            ->assertStatus(403);

        $this->be($this->admin)
            ->get("/account")
            ->assertStatus(200);
    }
}
