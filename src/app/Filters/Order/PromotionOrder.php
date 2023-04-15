<?php

namespace App\Filters\Order;

class PromotionOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'content', 'created_at'];
    }
}