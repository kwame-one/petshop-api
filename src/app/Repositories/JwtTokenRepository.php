<?php

namespace App\Repositories;

use App\Models\JwtToken;

class JwtTokenRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(JwtToken::class);
    }

    public function deleteByUserId($userId)
    {
        return JwtToken::query()
            ->where('user_id', '=', $userId)
            ->delete();
    }

}