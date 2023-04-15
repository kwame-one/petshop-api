<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_should_succeed(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']);
        $response->assertOk();
        $response->assertJsonPath('success', 1);
    }

    public function test_login_should_fail(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password1']);
        $response->assertUnprocessable();
        $response->assertJsonPath('success', 0);
    }

    public function test_create_user_should_succeed(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['avatar'] = Str::uuid();

        $response = $this->postJson("/api/v1/user/create", $data);
        $response->assertCreated();

    }

    public function test_create_user_should_return_validation_error(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password1';
        $data['avatar'] = Str::uuid();

        $response = $this->postJson("/api/v1/user/create", $data);
        $response->assertUnprocessable();

    }

    public function test_view_account_should_succeed()
    {
        $user = User::factory()->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password'])->json();
        $token = $loginResponse['data']['token'];
        $response = $this->withToken($token)->getJson("/api/v1/user");
        $response->assertOk();
    }
}
