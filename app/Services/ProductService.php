<?php

namespace App\Services;


class ProductService extends CoreService
{
    public function store(array $data): mixed
    {
        $product = parent::store($data);
        return ['uuid' => $product['uuid']];
    }
}