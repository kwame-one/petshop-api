<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\BrandOrder;

class BrandController extends CoreController
{
    protected function filters(): array
    {
        return [
            BrandOrder::class,
        ];
    }
}
