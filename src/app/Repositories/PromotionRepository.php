<?php

namespace App\Repositories;

use App\Models\Promotion;

class PromotionRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Promotion::class);
    }
}