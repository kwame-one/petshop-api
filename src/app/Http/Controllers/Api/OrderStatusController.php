<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\OrderStatusOrder;

class OrderStatusController extends CoreController
{
    protected function filters(): array
    {
        return [
            OrderStatusOrder::class,
        ];
    }
}
