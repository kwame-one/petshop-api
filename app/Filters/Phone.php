<?php

namespace App\Filters;


class Phone extends BaseEqualFilter
{

    public function field(): string
    {
        return 'phone';
    }

    public function column(): string
    {
        return 'phone_number';
    }
}