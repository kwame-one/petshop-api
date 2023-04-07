<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class CoreRepository implements ICoreRepository
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }


    public function store(array $data)
    {
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

        return $this->model::find($id);
    }


    public function delete($id): bool
    {
        $resource = $this->model::find($id);

        if (!$resource) {
            return false;
        }

        $resource->delete();

        return true;
    }

    public function findByIdAndHealthCentreId($id, $healthCentreId)
    {
        return $this->model::where('health_centre_id', $healthCentreId)
            ->where('id', $id)
            ->first();
    }

    public function findByIdAndHealthCentreIdAndBranch($id, $healthCentreId, $branch)
    {
        $product = $this->model::where('id', $id)
            ->where('health_centre_id', $healthCentreId);

        if($branch === 0)
        {
            $product->where('branch_id', 0);

        }else if ($branch !== null)
        {
            $product->where('branch_id', $branch->id);
        }

        return $product->first();
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
