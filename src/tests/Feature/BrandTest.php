<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_brand_with_valid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $brandData = Brand::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/brand/create', $brandData);
        $response->assertCreated();

        $this->assertDatabaseHas('brands', ['title' => $brandData['title']]);
    }

    public function test_create_brand_with_invalid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $brandData = Brand::factory()->make()->toArray();
        $brandData['title'] = null;

        $response = $this->withToken($token)->postJson('/api/v1/brand/create', $brandData);
        $response->assertUnprocessable();
    }

    public function test_create_brand_without_permissions()
    {
        $user = User::factory(['is_admin' => 0])->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $brandData = Brand::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/brand/create', $brandData);
        $response->assertForbidden();
    }

    public function test_list_all_brands()
    {
        Brand::factory(['id' => 1])->create();
        Brand::factory(['id' => 2])->create();
        $response = $this->getJson('/api/v1/brands');
        $response->assertOk();
        $response->assertJsonPath('total', 2);
    }
}
