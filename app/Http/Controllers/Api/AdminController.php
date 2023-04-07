<?php

namespace App\Http\Controllers\Api;

use App\Filters\Address;
use App\Filters\AdminUser;
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
    /**
     * store resource
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            $this->service->model()::storeRules(),
            $this->service->model()::errorMessages()
        );

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(null, null, $validator->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $data = $validator->validated();
        $data['is_admin'] = 1;

        return response()->json($this->service->store($data), Response::HTTP_CREATED);
    }

    protected function filters(): array
    {
        return [
            CreatedAt::class,
            AdminUser::class,
            FirstName::class,
            Phone::class,
            Address::class,
            Email::class,
            AdminOrder::class,
        ];
    }
}
