<?php

namespace App\Filters;


class Email extends BaseEqualFilter
{

    public function field(): string
    {
        return 'email';
    }

    public function column(): string
    {
        return 'email';
    }
}