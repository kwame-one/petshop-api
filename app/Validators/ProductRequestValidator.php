<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait ProductRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'category_uuid' => ['required', Rule::exists('categories', 'uuid')],
            'title' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'metadata' => ['required', 'array'],
            'metadata.image' => ['nullable', Rule::exists('files', 'uuid')],
            'metadata.brand' => ['required', Rule::exists('brands', 'uuid')],
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