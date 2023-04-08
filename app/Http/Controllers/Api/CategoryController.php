<?php

namespace App\Http\Controllers\Api;

use App\Filters\CreatedAt;
use App\Filters\Order\CategoryOrder;

class CategoryController extends CoreController
{
    protected function filters(): array
    {
        return [
            CreatedAt::class,
            CategoryOrder::class,
        ];
    }
}
