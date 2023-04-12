<?php

namespace App\Services;


use Illuminate\Support\Str;

class BrandService extends CoreService
{

    public function store(array $data): array
    {
        $data['slug'] = Str::slug($data['title']);
        $brand = parent::store($data);
        return ['uuid' => $brand['uuid']];
    }

    public function update($id, array $data): mixed
    {
        $data['slug'] = Str::slug($data['title']);
        return parent::update($id, $data);
    }
}