<?php

namespace App\Services;


use Illuminate\Support\Str;

class CategoryService extends CoreService
{

    public function store(array $data): array
    {
        $data['slug'] = Str::slug($data['title']);
        $category = parent::store($data);
        return ['uuid' => $category['uuid']];
    }

    public function update($id, array $data): mixed
    {
        $data['slug'] = Str::slug($data['title']);
        return parent::update($id, $data);
    }
}