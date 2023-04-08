<?php

namespace App\Filters;


class FirstName extends BaseEqualFilter
{

    public function field(): string
    {
        return 'first_name';
    }

    public function column(): string
    {
        return 'first_name';
    }
}