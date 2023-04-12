<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $name = fake()->name();
        return [
            'uuid' => Str::uuid(),
            'title' => $title,
            'content' => fake()->text(),
            'slug' => Str::slug($title),
            'metadata' => [
                'author' => $name,
                'image' => ''
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
