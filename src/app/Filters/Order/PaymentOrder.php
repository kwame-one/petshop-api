<?php

namespace App\Filters\Order;

class PaymentOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['type', 'created_at'];
    }
}