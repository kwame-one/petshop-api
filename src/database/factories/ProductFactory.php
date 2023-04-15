<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_uuid' => Category::factory()->create()->uuid,
            'uuid' => Str::uuid(),
            'title' => fake()->sentence(),
            'price' => fake()->randomDigitNotZero(),
            'description' => fake()->text(),
            'metadata' => [
                'brand' => Brand::factory()->create()->uuid,
                'image' => Str::uuid()
            ]
        ];
    }
}
