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
}
