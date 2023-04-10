<?php

namespace App\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait UserRequestValidator
{
    public static function storeRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3'],
            'last_name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', Password::default(), 'confirmed'],
            'avatar' => ['required'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'marketing' => ['nullable', 'string', Rule::in('1', '0')]
        ];
    }

    public static function updateRules($id): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3'],
            'last_name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id, 'uuid')],
            'password' => ['required', Password::default(), 'confirmed'],
            'avatar' => ['required'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'marketing' => ['nullable', 'string', Rule::in('1', '0')]
        ];
    }

    public static function errorMessages(): array
    {
        return [];
    }

    public static function forgotPasswordRules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')
                    ->where('is_admin', 0)
            ]
        ];
    }

    public static function forgotPasswordMessages()
    {
        return [
            'email.exists' => 'The email is invalid'
        ];
    }

    public static function resetPasswordRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }

}