<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends CoreController
{
    public function view(Request $request): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken($request->bearerToken());
        return response()->json(AppUtil::response(1, $this->service->find($uuid)));
    }
}
