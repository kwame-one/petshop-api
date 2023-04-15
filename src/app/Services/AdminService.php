<?php

namespace App\Services;

use App\Exceptions\AdminUpdateOrDeleteException;
use App\Repositories\ICoreRepository;
use App\Repositories\JwtTokenRepository;
use App\Utils\AppUtil;

class AdminService extends CoreService
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
    public function store(array $data): mixed
    {
        $data['password'] = bcrypt($data['password']);
        $data['is_admin'] = 1;
        $user = parent::store($data);
        $token = AppUtil::generateToken($user['uuid']);
        $user['token'] = $token;

        $jwtToken = [
            'user_id' => $user['id'],
            'token_title' => 'Token generated for '.$user['uuid'],
            'unique_id' => $token,
            'permissions' => AppUtil::readPermissions('admin'),
            'expires_at' => now()->addDays(30),
        ];

        $this->jwtTokenRepository->store($jwtToken);

        return $user;
    }


    /**
     * @throws AdminUpdateOrDeleteException
     */
    public function delete($id, $data=null): bool
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return false;
        }

        if ($resource->is_admin == 1) {
            throw new AdminUpdateOrDeleteException('failed to delete user');
        }

        $resource->delete();

        return true;
    }

    /**
     * @throws AdminUpdateOrDeleteException
     */
    public function update($id, array $data): mixed
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return false;
        }

        if ($resource->is_admin == 1) {
            throw new AdminUpdateOrDeleteException('failed to update user');
        }

        $resource->update($data);

        return $resource->fresh();
    }
}