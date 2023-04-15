<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->randomDigitNot(0),
            'uuid' => Str::uuid(),
            'email' => fake()->email(),
            'first_name' => fake()->name(),
            'last_name' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'email_verified_at' => null,
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => 0,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
