<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends CoreController
{
    public function view(Request $request): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken($request->bearerToken());
        return response()->json(AppUtil::response(1, $this->service->find($uuid)));
    }

    public function delete(Request $request): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken($request->bearerToken());
        $this->service->delete($uuid);
        return response()->json(AppUtil::response(1));
    }

    public function edit(Request $request): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken($request->bearerToken());
        $validator = Validator::make(
            $request->all(),
            $this->service->model()::updateRules($uuid),
            $this->service->model()::errorMessages()
        );

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(0, [], [], $validator->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $data = $validator->validated();

        $resource = $this->service->update($uuid, $data);

        return response()->json(AppUtil::response(1, $resource));

    }
}
