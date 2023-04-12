<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait FileRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png'],
        ];
    }

    public static function updateRules($id): array
    {
        return [

        ];
    }

    public static function errorMessages(): array
    {
        return [];
    }
}