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

    public function authenticate($email, $password, $isAdmin = false): bool|array
    {
        $user = $isAdmin ? $this->repository->findAdminByEmail($email) : $this->repository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        $token = AppUtil::generateToken($user['uuid']);

        $this->repository->updateLastLoginAt($user['uuid'], now());

        $jwtToken = [
            'user_id' => $user['id'],
            'token_title' => 'Token generated for ' . $user['uuid'],
            'unique_id' => $token,
            'permissions' => AppUtil::readPermissions($isAdmin ? 'admin' : 'user'),
            'expires_at' => now()->addDays(30),
        ];
        $this->jwtTokenRepository->store($jwtToken);

        return ['token' => $token];
    }

    public function logout($uuid, $isAdmin = false): bool
    {
        $user = $isAdmin ? $this->repository->findAdminByUuid($uuid) : $this->repository->findNonAdminByUuid($uuid);

        if (!$user) {
            return false;
        }

        $this->jwtTokenRepository->deleteByUserId($user['id']);

        return true;
    }

}