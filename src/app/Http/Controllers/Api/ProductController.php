<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\ProductOrder;
use App\Filters\ProductBrand;
use App\Filters\ProductCategory;
use App\Filters\ProductPrice;
use App\Filters\ProductTitle;

class ProductController extends CoreController
{
    protected function filters(): array
    {
        return [
            ProductOrder::class,
            ProductCategory::class,
            ProductBrand::class,
            ProductPrice::class,
            ProductTitle::class,
        ];
    }
}
