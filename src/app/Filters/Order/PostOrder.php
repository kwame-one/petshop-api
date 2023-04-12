<?php

namespace App\Filters\Order;

class PostOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['title', 'slug', 'content', 'created_at'];
    }
}