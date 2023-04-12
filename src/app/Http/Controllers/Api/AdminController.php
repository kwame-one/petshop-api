<?php

namespace App\Http\Controllers\Api;

use App\Filters\Address;
use App\Filters\NonAdminUser;
use App\Filters\CreatedAt;
use App\Filters\Email;
use App\Filters\FirstName;
use App\Filters\Order\AdminOrder;
use App\Filters\Phone;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends CoreController
{
    protected function filters(): array
    {
        return [
            CreatedAt::class,
            NonAdminUser::class,
            FirstName::class,
            Phone::class,
            Address::class,
            Email::class,
            AdminOrder::class,
        ];
    }
}
