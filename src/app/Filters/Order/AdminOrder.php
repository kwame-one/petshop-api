<?php

namespace App\Filters\Order;

class AdminOrder extends BaseOrder
{

    public function columns(): array
    {
        return ['first_name', 'last_name', 'address', 'phone_number', 'created_at', 'email', 'last_login_at'];
    }
}