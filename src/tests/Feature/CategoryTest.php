<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category_with_valid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $categoryData = Category::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/category/create', $categoryData);
        $response->assertCreated();

        $this->assertDatabaseHas('categories', ['title' => $categoryData['title']]);
    }

    public function test_create_category_with_invalid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $categoryData = Category::factory()->make()->toArray();
        $categoryData['title'] = null;

        $response = $this->withToken($token)->postJson('/api/v1/category/create', $categoryData);
        $response->assertUnprocessable();
    }

    public function test_create_category_without_permissions()
    {
        $user = User::factory(['is_admin' => 0])->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $categoryData = Category::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/category/create', $categoryData);
        $response->assertForbidden();
    }

}
