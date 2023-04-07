<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

}