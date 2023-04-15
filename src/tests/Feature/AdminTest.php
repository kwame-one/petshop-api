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
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['avatar'] = Str::uuid();

        $response = $this->postJson("/api/v1/admin/create", $data);
        $response->assertCreated();
        $this->assertDatabaseHas('users', ['email' => $data['email'], 'is_admin' => 1]);
    }

    public function test_create_admin_should_return_validation_error(): void
    {
        $data = User::factory()->make()->toArray();
        $data['avatar'] = Str::uuid();

        $response = $this->postJson("/api/v1/user/create", $data);
        $response->assertUnprocessable();
        $this->assertDatabaseMissing('users', ['email' => $data['email'], 'is_admin' => 1]);
    }

    public function test_list_all_users()
    {
        User::factory(['is_admin' => 0])->create();

        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $response = $this->withToken($token)->getJson('/api/v1/admin/user-listing');
        $response->assertOk();
        $response->assertJsonPath('total', 1);
    }
}
