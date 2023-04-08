<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(File::class);
    }
}