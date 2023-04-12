<?php

namespace App\Http\Controllers\Api;

use App\Filters\CreatedAt;
use App\Filters\Order\BrandOrder;

class BrandController extends CoreController
{
    protected function filters(): array
    {
        return [
            CreatedAt::class,
            BrandOrder::class,
        ];
    }
}
