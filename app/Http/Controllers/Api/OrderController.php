<?php

namespace App\Http\Controllers\Api;

use App\Filters\CreatedAt;
use App\Filters\Order\OrderSortBy;
use App\Filters\OrderAuth;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends CoreController
{
    public function store(Request $request): JsonResponse
    {
        $validator = $this->validatorStore($request);

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(0, [], null, $validator->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $data = $validator->validated();
        $data['uuid'] = AppUtil::getUserUuidFromToken($request->bearerToken());

        return response()->json(AppUtil::response(1, $this->service->store($data)), Response::HTTP_CREATED);

    }

    public function show($id): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken(request()->bearerToken());
        $resource = $this->service->find($id, ['uuid' => $uuid]);

        if (!$resource) {
            return response()->json(
                AppUtil::response(0, [], 'resource not found', []),
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(AppUtil::response(1, $resource), Response::HTTP_OK);
    }

    public function destroy($id): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken(request()->bearerToken());
        $deleted = $this->service->delete($id, ['uuid' => $uuid]);

        if (!$deleted) {
            return response()->json(
                AppUtil::response(0, [], 'resource not found', []),
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(AppUtil::response(1, [], null, []));
    }

    protected function filters(): array
    {
        return [
            CreatedAt::class,
            OrderSortBy::class,
            OrderAuth::class,
        ];
    }
}
