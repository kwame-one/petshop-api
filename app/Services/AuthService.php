<?php

namespace App\Services;

use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Utils\AppUtil;
use Illuminate\Support\Facades\Hash;

class AuthService extends CoreService
{
    private JwtTokenRepository $jwtTokenRepository;

    public function __construct(ICoreRepository $repository, JwtTokenRepository $jwtTokenRepository)
    {
        parent::__construct($repository);
        $this->jwtTokenRepository = $jwtTokenRepository;
    }

    public function authenticate($email, $password): bool|array
    {
        $user = $this->repository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        $token = AppUtil::generateToken($user['uuid']);

        $jwtToken = [
            'user_id' => $user['id'],
            'token_title' => 'Token generated for '.$user['uuid'],
            'unique_id' => $token,
            'expires_at' => now()->addDays(30),
        ];
        $this->jwtTokenRepository->store($jwtToken);

        return ['token' => $token];
    }

}