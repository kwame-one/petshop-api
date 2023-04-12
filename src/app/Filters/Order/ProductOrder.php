<?php

namespace App\Filters\Order;

class ProductOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'created_at', 'price', 'description'];
    }
}