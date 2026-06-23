<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'testa@example.com'],
            [
                'name' => 'Test Admin',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        $featuredRooms = [
            [
                'name' => 'Homestay View Biển Vũng Tàu',
                'price' => 650000,
                'address' => 'Vũng Tàu',
                'description' => 'Homestay sát biển, thích hợp nghỉ dưỡng cuối tuần.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'suite',
            ],
            [
                'name' => 'CloudStay Đà Lạt Garden',
                'price' => 800000,
                'address' => 'Đà Lạt',
                'description' => 'Không gian sân vườn yên tĩnh, gần Hồ Xuân Hương.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'family_suite',
            ],
            [
                'name' => 'Homestay Phố Cổ Hội An',
                'price' => 720000,
                'address' => 'Hội An, Quảng Nam',
                'description' => 'Thiết kế cổ điển, gần Chùa Cầu và khu phố đi bộ.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945',
                'status' => 'available',
                'capacity' => 3,
                'type' => 'vip',
            ],
        ];

        foreach ($featuredRooms as $room) {
            Room::updateOrCreate(
                ['name' => $room['name']],
                $room
            );
        }
    }
}
