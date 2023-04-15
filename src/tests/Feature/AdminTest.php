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
        User::factory(['is_admin' => 0, 'id' => 100])->create();

        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $response = $this->withToken($token)->getJson('/api/v1/admin/user-listing');
        $response->assertOk();
        $response->assertJsonPath('total', 1);
    }

    public function test_list_all_users_should_return_empty_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $response = $this->withToken($loginResponse['data']['token'])->getJson('/api/v1/admin/user-listing');
        $response->assertOk();
        $response->assertJsonPath('total', 0);
    }

    public function test_edit_user_should_succeed()
    {
        $nonAdmin = User::factory(['is_admin' => 0, 'id' => 10])->create();
        $data = $nonAdmin->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';
        $data['phone_number'] = '1111111111';

        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $response = $this->withToken($loginResponse['data']['token'])->putJson(
            '/api/v1/admin/user-edit/' . $nonAdmin->uuid,
            $data
        );

        $response->assertOk();
        $this->assertDatabaseHas('users', ['is_admin' => 0, 'phone_number' => '1111111111']);
    }

    public function test_edit_user_should_fail()
    {
        $Admin = User::factory(['is_admin' => 1, 'id' => 10])->create();
        $data = $Admin->toArray();
        $data['password'] = 'password';
        $data['password_confirmation'] = 'password';

        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $response = $this->withToken($loginResponse['data']['token'])->putJson(
            '/api/v1/admin/user-edit/' . $Admin->uuid,
            $data
        );

        $response->assertUnprocessable();
    }

    public function test_delete_user_should_succeed()
    {
        $nonAdmin = User::factory(['is_admin' => 0, 'id' => 10])->create();

        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $response = $this->withToken($loginResponse['data']['token'])->deleteJson(
            '/api/v1/admin/user-delete/' . $nonAdmin->uuid
        );

        $response->assertOk();
    }
}
