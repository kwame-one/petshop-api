<?php

namespace App\Filters\Order;

class OrderStatusOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'created_at'];
    }
}