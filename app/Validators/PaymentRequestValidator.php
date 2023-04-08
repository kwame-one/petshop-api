<?php

namespace App\Validators;

use App\Constants\PaymentType;
use Illuminate\Validation\Rule;

trait PaymentRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in([
                    PaymentType::BANK_TRANSFER,
                    PaymentType::CREDIT_CARD,
                    PaymentType::CASH_ON_DELIVERY,
                ])
            ],
            'details' => ['required', 'array'],

            'details.holder_name' => ['nullable', 'string', 'required_if:type,'.PaymentType::CREDIT_CARD],
            'details.number' => ['nullable', 'string', 'required_if:type,'.PaymentType::CREDIT_CARD],
            'details.ccv' => ['nullable', 'integer', 'required_if:type,'.PaymentType::CREDIT_CARD],
            'details.expire_date' => ['nullable', 'string', 'required_if:type,'.PaymentType::CREDIT_CARD],

            'details.first_name' => ['nullable', 'string', 'required_if:type,'.PaymentType::CASH_ON_DELIVERY],
            'details.last_name' => ['nullable', 'string', 'required_if:type,'.PaymentType::CASH_ON_DELIVERY],
            'details.address' => ['nullable', 'string', 'required_if:type,'.PaymentType::CASH_ON_DELIVERY],

            'details.swift' => ['nullable', 'string', 'required_if:type,'.PaymentType::BANK_TRANSFER],
            'details.iban' => ['nullable', 'string', 'required_if:type,'.PaymentType::BANK_TRANSFER],
            'details.name' => ['nullable', 'string', 'required_if:type,'.PaymentType::BANK_TRANSFER],
        ];
    }

    public static function updateRules($id): array
    {
        return self::storeRules();
    }

    public static function errorMessages(): array
    {
        return [];
    }
}