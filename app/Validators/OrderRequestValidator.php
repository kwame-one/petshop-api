<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait OrderRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'order_status_uuid' => ['required', 'string',
                Rule::exists('order_statuses', 'uuid'),
            ],
            'payment_uuid' => ['required', 'string',
                Rule::exists('payments', 'uuid'),
            ],
            'products' => ['required', 'array', 'min:1'],
            'products.*.uuid' => ['required', 'string', 'distinct',
                Rule::exists('products', 'uuid')
                    ->whereNull('deleted_at'),
            ],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'array'],
            'address.billing' => ['required', 'string'],
            'address.shipping' => ['required', 'string'],
        ];
    }

    public static function updateRules($id): array
    {
        return [

        ];
    }

    public static function errorMessages(): array
    {
        return [
            'products.*.quantity.required' => 'Quantity for item #:position is required',
            'products.*.quantity.integer' => 'Quantity for item #:position must be a whole number',
            'products.*.uuid.required' => 'Product for item #:position is required',
            'products.*.uuid.exists' => 'Product for item #:position is invalid',
            'products.*.uuid.distinct' => 'Product for item #:position has already been added',
        ];
    }
}