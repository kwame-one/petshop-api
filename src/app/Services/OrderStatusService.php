<?php

namespace App\Services;

class OrderStatusService extends CoreService
{
    public function store(array $data): array
    {
        $orderStatus = parent::store($data);
        return ['uuid' => $orderStatus['uuid']];
    }
}