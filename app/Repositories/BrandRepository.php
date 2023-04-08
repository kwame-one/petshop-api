<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Brand::class);
    }

    public function findByIdIn($ids): Collection|array
    {
        return Brand::query()->whereIn('uuid', $ids)->get();
    }
}