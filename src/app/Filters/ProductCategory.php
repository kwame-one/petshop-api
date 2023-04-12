<?php

namespace App\Filters;


class ProductCategory extends BaseEqualFilter
{

    public function field(): string
    {
        return 'category';
    }

    public function column(): string
    {
        return 'category_uuid';
    }
}