<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\PromotionOrder;
use App\Filters\PromotionValid;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromotionController extends CoreController
{
    protected function filters(): array
    {
        return [
            PromotionOrder::class,
            PromotionValid::class,
        ];
    }
}
