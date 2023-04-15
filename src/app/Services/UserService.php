<?php

namespace App\Services;

use App\Exceptions\AdminUpdateOrDeleteException;
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
            'permissions' => AppUtil::readPermissions('user'),
            'expires_at' => now()->addDays(30),
        ];

        $this->jwtTokenRepository->store($jwtToken);

        return $user;
    }

    /**
     * @throws AdminUpdateOrDeleteException
     */
    public function update($id, array $data): mixed
    {
        $user = $this->repository->find($id);
        if (!$user) {
            return false;
        }

        if ($user->is_admin == 1) {
            throw new AdminUpdateOrDeleteException('Failed to update user');
        }
        $data['password'] = bcrypt($data['password']);
        return $this->repository->update($id, $data);
    }

    /**
     * @throws AdminUpdateOrDeleteException
     */
    public function delete($id, $data = null): bool
    {
        $user = $this->repository->find($id);
        if (!$user) {
            return false;
        }

        if ($user->is_admin == 1) {
            throw new AdminUpdateOrDeleteException('Failed to delete user');
        }

        $user->delete();
        return true;
    }

    public function sendPasswordResetToken(array $data): array
    {
        $data['token'] = Str::random(100);
        $passwordReset = $this->passwordResetRepository->updateOrCreate($data);
        return ['reset_token' => $passwordReset['token']];
    }

    public function resetPassword(array $data): bool
    {
        $resetToken = $this->passwordResetRepository->findByEmailAndToken($data['email'], $data['token']);
        if (!$resetToken) {
            return false;
        }
        $password = bcrypt($data['password']);
        $user = $this->repository->findByEmail($data['email']);
        $this->repository->update($user['uuid'], ['password' => $password]);
        $this->passwordResetRepository->deleteByEmail($data['email']);

        return true;

    }

}