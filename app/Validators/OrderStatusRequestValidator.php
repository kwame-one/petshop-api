<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait OrderStatusRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
        ];
    }

    public static function errorMessages(): array
    {
        return [];
    }
}