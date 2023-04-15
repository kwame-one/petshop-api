<?php

namespace Tests\Feature;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
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


    public function test_list_all_order_statuses()
    {
        OrderStatus::factory(['id' => 1])->create();
        $response = $this->getJson('/api/v1/order-statuses');
        $response->assertOk();
        $response->assertJsonPath('total', 1);
    }

    public function test_fetch_order_status_by_uuid()
    {
        $orderStatus = OrderStatus::factory(['id' => 1])->create();
        $response = $this->getJson('/api/v1/order-status/' . $orderStatus->uuid);
        $response->assertOk();
    }

    public function test_fetch_order_status_by_uuid_not_found()
    {
        $response = $this->getJson('/api/v1/order-status/' . Str::uuid());
        $response->assertNotFound();
    }

    public function test_delete_order_status_by_uuid()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];
        $orderStatus = OrderStatus::factory(['id' => 10])->create();
        $response = $this->withToken($token)->deleteJson('/api/v1/order-status/' . $orderStatus->uuid);
        $response->assertOk();

        $this->assertDatabaseMissing('order_statuses', ['uuid' => $orderStatus->uuid]);
    }

    public function test_delete_order_status_without_permissions()
    {
        $user = User::factory(['is_admin' => 0])->create();
        $loginResponse = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $orderStatus = OrderStatus::factory(['id' => 1])->create();

        $response = $this->withToken($token)->deleteJson('/api/v1/order-status/' . $orderStatus->uuid);
        $response->assertForbidden();
    }

    public function test_update_order_status()
    {
        $user = User::factory(['is_admin' => 1])->create();
        $loginResponse = $this->postJson("/api/v1/admin/login", ['email' => $user->email, 'password' => 'password']
        )->json();
        $token = $loginResponse['data']['token'];

        $orderStatus = OrderStatus::factory()->create();
        $orderStatus['title'] = 'new order status name';

        $response = $this->withToken($token)->putJson('/api/v1/order-status/' . $orderStatus->uuid, $orderStatus->toArray());
        $response->assertOk();

        $this->assertDatabaseHas('order_statuses', ['uuid' => $orderStatus->uuid, 'title' => 'new order status name']);
    }

}
