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

    public function test_login(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson("/api/v1/user/login", ['email' => $user->email, 'password' => 'password']);
        $response->assertOk();
        $response->assertJsonPath('success', 1);
    }
}
