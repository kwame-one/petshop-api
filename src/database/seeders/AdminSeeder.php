<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'uuid' => Str::uuid(),
                'first_name' => 'John',
                'last_name' => 'Doe',
                'password' => bcrypt('password'),
                'avatar' => Str::uuid(),
                'address' => 'Accra, Ghana',
                'phone_number' => '0000000000',
                'is_marketing' => 1,
            ]
        );
    }
}
