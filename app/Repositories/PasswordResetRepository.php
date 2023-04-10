<?php

namespace App\Repositories;

use App\Models\PasswordReset;

class PasswordResetRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(PasswordReset::class);
    }

    public function updateOrCreate($data)
    {
        return PasswordReset::query()
            ->updateOrCreate(
                ['email' => $data['email']],
                $data
            );
    }

    public function findByEmailAndToken($email, $token)
    {
        return PasswordReset::query()
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->first();
    }

    public function deleteByEmail($email)
    {
        return PasswordReset::query()
            ->where('email', '=', $email)
            ->delete();
    }
}