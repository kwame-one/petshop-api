<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_should_succeed(): void
    {
        $admin = User::factory(['is_admin' => 1])->create();
        $response = $this->postJson("/api/v1/admin/login", ['email' => $admin->email, 'password' => 'password']);
        $response->assertOk();
        $response->assertJsonPath('success', 1);
    }

    public function test_admin_login_should_fail(): void
    {
        $user = User::factory(['is_admin' => 1])->create();
        $response = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password1']);
        $response->assertUnprocessable();
        $response->assertJsonPath('success', 0);
    }

    public function test_create_admin_should_succeed(): void
    {
        $data = User::factory(['is_admin' => 1])->make()->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['avatar'] = Str::uuid();

        $response = $this->postJson("/api/v1/admin/create", $data);
        $response->assertCreated();
    }
}
