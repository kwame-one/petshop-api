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

    private function authenticate($data, $isAdmin = false) {
        $validator = Validator::make($data, [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(0, [], [], $validator->errors()),
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