<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\CoreController;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends CoreController
{
    public function loginUser(Request $request): JsonResponse
    {
       return $this->authenticate($request->all());
    }

    public function loginAdmin(Request $request): JsonResponse
    {
        return $this->authenticate($request->all(), true);
    }

    public function logoutUser(Request $request): JsonResponse
    {
        return $this->logout($request->bearerToken());
    }
    public function logoutAdmin(Request $request): JsonResponse
    {
        return $this->logout($request->bearerToken(), true);
    }

    private function logout($token, $isAdmin = false): JsonResponse
    {
        $uuid = AppUtil::getUserUuidFromToken($token);
        $this->service->logout($uuid, $isAdmin);
        return response()->json(AppUtil::response(1));
    }

    private function authenticate($data, $isAdmin = false): JsonResponse
    {
        $validator = Validator::make($data, [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(0, [], null, $validator->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $data = $validator->validated();
        $user = $this->service->authenticate($data['email'], $data['password'], $isAdmin);

        if (!$user) {
            return response()->json(
                AppUtil::response(0, [], 'Failed to authenticate user'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return response()->json(AppUtil::response(1, $user));
    }
}
