<?php

namespace App\Filters\Order;

class OrderSortBy extends BaseOrder
{

    public function columns(): array
    {
        return ['address', 'orders.created_at', 'amount'];
    }
}