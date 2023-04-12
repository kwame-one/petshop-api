<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\PaymentOrder;

class PaymentController extends CoreController
{
    protected function filters(): array
    {
        return [
            PaymentOrder::class,
        ];
    }
}
