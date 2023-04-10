<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }
}