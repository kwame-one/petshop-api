<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function findNonAdminByUuid($id): null|object
    {
        return User::query()->where('uuid', $id)
            ->where('is_admin', 0)
            ->first();
    }

    public function findAdminByUuid($id): null|object
    {
        return User::query()->where('uuid', $id)
            ->where('is_admin', 1)
            ->first();
    }

    public function findByEmail($email)
    {
        return User::query()->where('email', '=', $email)->first();
    }

    public function findAdminByEmail($email)
    {
        return User::query()
            ->where('email', '=', $email)
            ->where('is_admin', '=', 1)
            ->first();
    }

    public function updateLastLoginAt($uuid, $timestamp): int
    {
        return User::query()->where('uuid', '=', $uuid)
            ->update(['last_login_at' => $timestamp]);
    }

}