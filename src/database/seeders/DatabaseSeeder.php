<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            OrderStatusSeeder::class,
            PostSeeder::class,
            PromotionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
