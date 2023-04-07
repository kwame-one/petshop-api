<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ICoreService;
use App\Utils\AppUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class CoreController extends Controller
{
    protected ICoreService $service;

    /**
     * inject service
     *
     * @return void
     */
    public function __construct(ICoreService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all resources
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return AppUtil::paginate(
            app(Pipeline::class)
                ->send($this->service->findAll())
                ->through($this->filters())
                ->thenReturn()
        );
    }

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

        return response()->json($this->service->store($data), Response::HTTP_CREATED);
    }

    /**
     * update
     *
     * @param  $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $data = $request->validate($this->service->model()::updateRules($id), $this->service->model()::errorMessages());

        $resource = $this->service->update($id, $data);

        if (!$resource) {
            return response()->json(['message' => 'resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($resource);
    }

    /**
     * Delete resource
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * find resource
     *
     * @param  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $resource = $this->service->find($id);

        if (!$resource) {
            return response()->json(['message' => 'resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($resource, Response::HTTP_OK);
    }


    /**
     * filters for filtering resources
     *
     * @return array
     */
    protected function filters(): array
    {
        return [];
    }
}
