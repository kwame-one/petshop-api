<?php

namespace App\Services;


use App\Constants\PaymentType;
use Illuminate\Support\Arr;

class PaymentService extends CoreService
{
    public function store(array $data): array
    {
        $data['details'] = $this->formatData($data['type'], $data['details']);
        $payment = parent::store($data);
        return ['uuid' => $payment['uuid']];
    }

    public function update($id, array $data): mixed
    {
        $data['details'] = $this->formatData($data['type'], $data['details']);
        return parent::update($id, $data);
    }

    private function formatData($type, $details): array
    {
        $data = [];
        if ($type == PaymentType::BANK_TRANSFER) {
            $data['swift'] = Arr::pull($details, 'swift');
            $data['iban'] = Arr::pull($details, 'iban');
            $data['name'] = Arr::pull($details, 'name');
        } elseif ($type == PaymentType::CREDIT_CARD) {
            $data['holder_name'] = Arr::pull($details, 'holder_name');
            $data['number'] = Arr::pull($details, 'number');
            $data['ccv'] = Arr::pull($details, 'ccv');
            $data['expire_date'] = Arr::pull($details, 'expire_date');
        } else {
            $data['first_name'] = Arr::pull($details, 'first_name');
            $data['last_name'] = Arr::pull($details, 'last_name');
            $data['address'] = Arr::pull($details, 'address');
        }
        return $data;
    }

}