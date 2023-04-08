<?php

namespace App\Http\Controllers\Api;

use App\FileUploader\FileFileUploader;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $data = AppUtil::uploadFile($data, FileFileUploader::class);

        return response()->json(AppUtil::response(1, $this->service->store($data)), Response::HTTP_CREATED);
    }

    public function view($id): BinaryFileResponse|JsonResponse
    {
        $resource = $this->service->find($id);

        if (!$resource) {
            return response()->json(
                AppUtil::response(0, [], 'file not found', []),
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->download(public_path($resource['path']));
    }
}
