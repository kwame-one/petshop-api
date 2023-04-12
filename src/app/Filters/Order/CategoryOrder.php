<?php

namespace App\Filters\Order;

class CategoryOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'created_at'];
    }
}