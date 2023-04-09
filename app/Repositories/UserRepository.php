<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function findNonAdminById($id): null|object
    {
        return User::query()->where('uuid', $id)
            ->where('is_admin', 0)
            ->first();
    }

    public function findByEmail($email)
    {
        return User::query()->where('email', '=', $email)->first();
    }

}