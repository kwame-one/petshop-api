<?php

namespace App\Filters;


class Address extends BaseFilter
{

    public function field(): string
    {
        return 'address';
    }

    public function column(): string
    {
        return 'address';
    }
}