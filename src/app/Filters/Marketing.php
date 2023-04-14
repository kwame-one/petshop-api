<?php

namespace App\Filters;


class Marketing extends BaseEqualFilter
{

    public function field(): string
    {
        return 'marketing';
    }

    public function column(): string
    {
        return 'is_marketing';
    }
}