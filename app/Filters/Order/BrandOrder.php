<?php

namespace App\Filters\Order;

class BrandOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'created_at'];
    }
}