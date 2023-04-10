<?php

namespace App\Services;

use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Repositories\PasswordResetRepository;
use App\Utils\AppUtil;
use Illuminate\Support\Str;

class UserService extends CoreService
{
    private JwtTokenRepository $jwtTokenRepository;
    private PasswordResetRepository $passwordResetRepository;

    public function __construct(
        ICoreRepository $repository,
        JwtTokenRepository $jwtTokenRepository,
        PasswordResetRepository $passwordResetRepository
    ) {
        parent::__construct($repository);
        $this->jwtTokenRepository = $jwtTokenRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @throws \Exception
     */
    public function store(array $data): mixed
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->repository->store($data);
        $token = AppUtil::generateToken($user['uuid']);
        $user['token'] = $token;

        $jwtToken = [
            'user_id' => $user['id'],
            'token_title' => 'Token generated for ' . $user['uuid'],
            'unique_id' => $token,
            'expires_at' => now()->addDays(30),
        ];

        $this->jwtTokenRepository->store($jwtToken);

        return $user;
    }

    public function update($id, array $data): mixed
    {
        $data['password'] = bcrypt($data['password']);
        return parent::update($id, $data);
    }

    public function sendPasswordResetToken(array $data): array
    {
        $data['token'] = Str::random(100);
        $passwordReset = $this->passwordResetRepository->updateOrCreate($data);
        return ['reset_token' => $passwordReset['token']];
    }

}