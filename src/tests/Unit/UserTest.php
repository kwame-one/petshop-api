<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Repositories\PasswordResetRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_store_user(): void
    {
        $data = User::factory()->make()->toArray();
        $data['id'] = 1;
        $data['password'] = 'password';

        $userMock = Mockery::spy(ICoreRepository::class);
        $jwtMock = Mockery::spy(JwtTokenRepository::class);
        $passwordResetMock = Mockery::spy(PasswordResetRepository::class);

        $service = new UserService($userMock, $jwtMock, $passwordResetMock);

        $userMock->shouldReceive('store')->once()->andReturn($data);

        $service->store($data);

    }

}
