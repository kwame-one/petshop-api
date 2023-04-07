<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * store user.
     *
     * @return void
     * @throws \Exception
     */
    public function test_store_user(): void
    {
        $data = User::factory()->make()->toArray();
        $data['id'] = 1;

        $userMock = Mockery::spy(ICoreRepository::class);
        $jwtMock = Mockery::spy(JwtTokenRepository::class);

        $service = new UserService($userMock, $jwtMock);

        $userMock->shouldReceive('store')->once()->andReturn($data);

        $data = User::factory()->make()->toArray();

        $service->store($data);

        $userMock->shouldHaveReceived('store')->once()->with($data);

    }

}
