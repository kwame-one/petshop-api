<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }

    public function findByIdAndUserId($id, $userId)
    {
        return Order::query()
            ->where('uuid', '=', $id)
            ->where('user_id', '=', $userId)
            ->first();

    }
}