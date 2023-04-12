<?php

namespace App\Filters;


class CustomerUuid extends BaseEqualFilter
{

    public function field(): string
    {
        return 'customerUuid';
    }

    public function column(): string
    {
        return 'users.uuid';
    }
}