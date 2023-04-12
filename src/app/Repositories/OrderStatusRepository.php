<?php

namespace App\Repositories;

use App\Models\OrderStatus;

class OrderStatusRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(OrderStatus::class);
    }
}