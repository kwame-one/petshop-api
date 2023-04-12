<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}