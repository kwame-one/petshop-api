<?php

namespace App\Http\Controllers\Api;

use App\Filters\Order\PostOrder;

class PostController extends CoreController
{
    protected function filters(): array
    {
        return [
            PostOrder::class,
        ];
    }
}
