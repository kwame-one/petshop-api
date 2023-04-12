<?php

namespace App\Services;


use App\Utils\AppUtil;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileService extends CoreService
{
    public function store(array $data): mixed
    {
        $file = $data['path'];
        $data['name'] = Str::random();
        $data['type'] = File::mimeType($file);
        $data['size'] = AppUtil::humanFilesize(File::size($file));
        return parent::store($data);
    }
}