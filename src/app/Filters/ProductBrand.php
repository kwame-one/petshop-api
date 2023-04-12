<?php

namespace App\Filters;


class ProductBrand extends BaseEqualFilter
{

    public function field(): string
    {
        return 'brand';
    }

    public function column(): string
    {
        return 'metadata->brand';
    }
}