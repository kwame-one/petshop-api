<?php

namespace App\Repositories;

use App\Models\JwtToken;

class JwtTokenRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(JwtToken::class);
    }

}