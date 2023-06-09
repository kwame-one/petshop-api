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
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $response = $this->withToken($token)->getJson("/api/v1/user");
        $response->assertOk();
    }

    public function test_view_account_should_fail()
    {
        $response = $this->withToken('adada')->getJson("/api/v1/user");
        $response->assertUnauthorized();
    }

    public function test_update_account_details()
    {
        $user = User::factory()->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $data = $user->toArray();

        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['address'] = 'new_address';
        $response = $this->withToken($token)->putJson("/api/v1/user/edit", $data);
        $response->assertOk();
        $this->assertDatabaseHas('users', ['address' => 'new_address']);
    }

    public function test_update_account_details_with_invalid_data()
    {
        $user = User::factory()->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $data = $user->toArray();

        $data['password'] = 'password';
        $data['address'] = 'new_address';
        $response = $this->withToken($token)->putJson("/api/v1/user/edit", $data);
        $response->assertUnprocessable();
    }

    public function test_update_account_details_without_token()
    {
        $user = User::factory()->create();
        $response = $this->putJson("/api/v1/user/edit", $user->toArray());
        $response->assertUnauthorized();
    }

    public function test_delete_user_account_should_succeed()
    {
        $user = User::factory()->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $response = $this->withToken($token)->deleteJson('/api/v1/user');
        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_user_account_should_fail()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/v1/user');
        $response->assertUnauthorized();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
