<?php

namespace App\Filters;


class ProductTitle extends BaseLikeFilter
{

    public function field(): string
    {
        return 'title';
    }

    public function column(): string
    {
        return 'title';
    }
}