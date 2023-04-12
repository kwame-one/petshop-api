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

    public function shippedOrders()
    {
        return Order::query()
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            ->where('order_statuses.title', '=', 'shipped')
            ->select(['orders.*']);
    }
}