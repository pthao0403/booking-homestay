<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $fallbackFeaturedRooms = collect([
            (object) [
                'name' => 'CloudStay Đà Lạt Pine View',
                'price' => 850000,
                'address' => 'Đường Triệu Việt Vương, Đà Lạt, Lâm Đồng',
                'description' => 'Homestay yên tĩnh giữa đồi thông, phù hợp cho cặp đôi muốn nghỉ dưỡng và ngắm thành phố trong sương sớm.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200',
                'status' => 'available',
                'capacity' => 2,
                'type' => 'suite',
                'id' => null,
            ],
            (object) [
                'name' => 'CloudStay Hội An Riverside',
                'price' => 920000,
                'address' => 'Đường Bạch Đằng, Hội An, Quảng Nam',
                'description' => 'Không gian ấm cúng sát sông, nội thất nhẹ nhàng và vị trí đẹp để tận hưởng phố cổ vào buổi tối.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'family_suite',
                'id' => null,
            ],
            (object) [
                'name' => 'CloudStay Phú Quốc Ocean Breeze',
                'price' => 1250000,
                'address' => 'Bãi Trường, Phú Quốc, Kiên Giang',
                'description' => 'Homestay gần biển với ban công rộng, phong cách hiện đại và không gian thư giãn phù hợp cho kỳ nghỉ cao cấp.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200',
                'status' => 'available',
                'capacity' => 3,
                'type' => 'vip',
                'id' => null,
            ],
        ]);

        try {
            $featuredRooms = Room::query()
                ->where('status', 'available')
                ->where('is_featured', true)
                ->latest()
                ->take(3)
                ->get();

            $rooms = Room::query()
                ->where('status', 'available')
                ->latest()
                ->take(10)
                ->get();
        } catch (\Throwable $e) {
            $featuredRooms = $fallbackFeaturedRooms;
            $rooms = new Collection();
        }

        if ($featuredRooms->isEmpty()) {
            $featuredRooms = $fallbackFeaturedRooms;
        }

        return view('home.index', compact('rooms', 'featuredRooms'));
    }
}
