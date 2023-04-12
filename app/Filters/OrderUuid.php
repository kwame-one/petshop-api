<?php

namespace App\Filters;


class OrderUuid extends BaseEqualFilter
{

    public function field(): string
    {
        return 'orderUuid';
    }

    public function column(): string
    {
        return 'orders.uuid';
    }
}