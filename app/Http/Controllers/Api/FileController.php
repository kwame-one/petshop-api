<?php

namespace App\Http\Controllers\Api;

use App\FileUploader\FileFileUploader;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FileController extends CoreController
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            $this->service->model()::storeRules(),
            $this->service->model()::errorMessages()
        );

        if ($validator->fails()) {
            return response()->json(
                AppUtil::response(0, [], null, $validator->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $data = $validator->validated();
        $file = $request->file('file');

        $data = AppUtil::uploadFile($data, FileFileUploader::class);

        return response()->json(AppUtil::response(1, $this->service->store($data)), Response::HTTP_CREATED);
    }
}
