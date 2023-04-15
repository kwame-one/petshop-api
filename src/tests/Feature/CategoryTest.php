<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
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

    public function test_list_all_categories()
    {
        Category::factory(['id' => 1])->create();
        $response = $this->getJson('/api/v1/categories');
        $response->assertOk();
        $response->assertJsonPath('total', 1);
    }

    public function test_fetch_category_by_uuid()
    {
        $category = Category::factory(['id' => 1])->create();
        $response = $this->getJson('/api/v1/category/' . $category->uuid);
        $response->assertOk();
    }

    public function test_fetch_category_by_uuid_not_found()
    {
        $response = $this->getJson('/api/v1/category/' . Str::uuid());
        $response->assertNotFound();
    }

    public function test_delete_category_by_uuid()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $category = Category::factory(['id' => 10])->create();
        $response = $this->withToken($token)->deleteJson('/api/v1/category/' . $category->uuid);
        $response->assertOk();

        $this->assertDatabaseMissing('categories', ['uuid' => $category->uuid]);
    }

    public function test_delete_category_without_permissions()
    {
        $user = User::factory(['is_admin' => 0])->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $category = Category::factory(['id' => 1])->create();

        $response = $this->withToken($token)->deleteJson('/api/v1/category/' . $category->uuid);
        $response->assertForbidden();
    }

    public function test_update_category()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $category = Category::factory()->create();
        $category['title'] = 'new category name';

        $response = $this->withToken($token)->putJson('/api/v1/category/' . $category->uuid, $category->toArray());
        $response->assertOk();

        $this->assertDatabaseHas('categories', ['uuid' => $category->uuid, 'title' => 'new category name']);
    }

}
