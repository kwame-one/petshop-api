<?php

namespace App\Services;

use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Utils\AppUtil;

class UserService extends CoreService
{
    private JwtTokenRepository $jwtTokenRepository;

    public function __construct(ICoreRepository $repository, JwtTokenRepository $jwtTokenRepository)
    {
        parent::__construct($repository);
        $this->jwtTokenRepository = $jwtTokenRepository;
    }

    /**
     * @throws \Exception
     */
    public function store(array $data): array
    {
        $user = parent::store($data);
        $token = AppUtil::generateToken($user['uuid']);
        $user['token'] = $token;

        $jwtToken = [
            'user_id' => $user['id'],
            'token_title' => 'Token generated for '.$user['uuid'],
            'unique_id' => $token,
            'expires_at' => now()->addDays(30),
        ];

        $this->jwtTokenRepository->store($jwtToken);

        return $user;
    }

}