<?php

namespace App\Filters\Order;

class OrderSortBy extends BaseOrder
{

    public function columns(): array
    {
        return ['address', 'created_at', 'amount'];
    }
}