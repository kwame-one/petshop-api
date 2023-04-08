<?php

namespace App\Http\Controllers\Api;

use App\Filters\CreatedAt;
use App\Filters\Order\PaymentOrder;

class PaymentController extends CoreController
{
    protected function filters(): array
    {
        return [
            CreatedAt::class,
            PaymentOrder::class,
        ];
    }
}
