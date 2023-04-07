<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CoreRepository implements ICoreRepository
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }


    public function store(array $data)
    {
        $data['uuid'] = Str::uuid();
        return $this->model::create($data);
    }


    public function update($id, array $data)
    {
        $resource = $this->find($id);

        if (!$resource) {
            return false;
        }

        $resource->update($data);

        return $resource->fresh();
    }


    public function find($id)
    {

        return $this->model::where('uuid', $id)->first();
    }


    public function delete($id): bool
    {
        $resource = $this->find($id);

        if (!$resource) {
            return false;
        }

        $resource->delete();

        return true;
    }

    public function findAll() : Builder
    {
        return $this->model::query();
    }

    public function model()
    {
        return $this->model;
    }
}
