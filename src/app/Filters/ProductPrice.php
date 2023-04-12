<?php

namespace App\Filters;


class ProductPrice extends BaseEqualFilter
{

    public function field(): string
    {
        return 'price';
    }

    public function column(): string
    {
        return 'price';
    }
}