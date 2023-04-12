<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Brand::class);
    }
}