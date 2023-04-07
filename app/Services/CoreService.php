<?php

namespace App\Services;

use App\Repositories\ICoreRepository;
use Illuminate\Database\Eloquent\Builder;

abstract class CoreService implements ICoreService
{
    protected ICoreRepository $repository;

    public function __construct(ICoreRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * store resource
     *
     * @param  array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->repository->store($data);
    }

    /**
     * update resource
     *
     * @param  $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return false;
        }

        $resource->update($data);

        return $resource->fresh();
    }

    /**
     * find resource
     *
     * @param  $id
     * @param array $data
     * @return mixed
     */

    public function find($id, $data=null): mixed
    {
        return $this->repository->find($id);
    }


    /**
     * delete resource
     *
     * @param  $id
     * @param array $data
     * @return bool
     */
    public function delete($id, $data=null): bool
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return false;
        }

        $resource->delete();

        return true;
    }

    /**
     * view all resources
     *
     * @return Builder
     */
    public function findAll() : Builder
    {
        return $this->repository->findAll();
    }

}
