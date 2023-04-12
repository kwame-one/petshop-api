<?php

namespace App\Http\Controllers\Api;

use App\Filters\Address;
use App\Filters\NonAdminUser;
use App\Filters\Email;
use App\Filters\FirstName;
use App\Filters\Order\AdminOrder;
use App\Filters\Phone;

class AdminController extends CoreController
{
    protected function filters(): array
    {
        return [
            NonAdminUser::class,
            FirstName::class,
            Phone::class,
            Address::class,
            Email::class,
            AdminOrder::class,
        ];
    }
}
