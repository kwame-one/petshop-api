<?php

namespace Tests\Feature;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_status_with_valid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $orderStatusData = OrderStatus::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/order-status/create', $orderStatusData);
        $response->assertCreated();

        $this->assertDatabaseHas('order_statuses', ['title' => $orderStatusData['title']]);
    }

    public function test_create_order_status_with_invalid_data()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $orderStatusData = OrderStatus::factory()->make()->toArray();
        $orderStatusData['title'] = null;

        $response = $this->withToken($token)->postJson('/api/v1/order-status/create', $orderStatusData);
        $response->assertUnprocessable();
    }

    public function test_create_order_status_without_permissions()
    {
        $user = User::factory(['is_admin' => 0])->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $orderStatusData = OrderStatus::factory()->make()->toArray();

        $response = $this->withToken($token)->postJson('/api/v1/order-status/create', $orderStatusData);
        $response->assertForbidden();
    }
}
