<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $to = fake()->date($format = 'Y-m-d');
        return [
            'uuid' => Str::uuid(),
            'title' => fake()->sentence(),
            'content' => fake()->text(),
            'metadata' => [
                'image' => Str::uuid(),
                'valid_to' => $to,
                'valid_from' => Carbon::parse($to)->subDays(rand(1, 100))->toDateString(),
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
