<?php

namespace App\Http\Controllers\Api;

use App\Filters\CreatedAt;
use App\Filters\Order\ProductOrder;

class ProductController extends CoreController
{
    protected function filters(): array
    {
        return [
            CreatedAt::class,
            ProductOrder::class,
        ];
    }
}
