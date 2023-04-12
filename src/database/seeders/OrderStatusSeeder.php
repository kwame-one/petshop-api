<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatuses = [
            [
                'title' => 'open',
                'uuid' => Str::uuid(),
            ],
            [
                'title' => 'pending payment',
                'uuid' => Str::uuid(),
            ],
            [
                'title' => 'paid',
                'uuid' => Str::uuid(),
            ],
            [
                'title' => 'shipped',
                'uuid' => Str::uuid(),
            ],
            [
                'title' => 'cancelled',
                'uuid' => Str::uuid(),
            ]
        ];

        foreach($orderStatuses as $status) {
            OrderStatus::query()->updateOrCreate(
                ['title' => $status['title']],
                ['uuid' => $status['uuid']]
            );
        }
    }
}
