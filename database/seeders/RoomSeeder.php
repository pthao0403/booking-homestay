<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'CloudStay Đà Lạt Pine View',
                'price' => 850000,
                'address' => 'Đường Triệu Việt Vương, Đà Lạt, Lâm Đồng',
                'description' => 'Homestay yên tĩnh giữa đồi thông, phù hợp cho cặp đôi hoặc nhóm bạn muốn tận hưởng không khí se lạnh và khung cảnh lãng mạn của Đà Lạt.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200',
                'status' => 'available',
                'capacity' => 2,
                'type' => 'suite',
                'is_featured' => true,
            ],
            [
                'name' => 'CloudStay Hội An Riverside',
                'price' => 920000,
                'address' => 'Đường Bạch Đằng, Hội An, Quảng Nam',
                'description' => 'Không gian ấm cúng sát sông, thiết kế pha trộn giữa phong cách truyền thống và tiện nghi hiện đại, rất phù hợp cho kỳ nghỉ thư giãn.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'family_suite',
                'is_featured' => true,
            ],
            [
                'name' => 'CloudStay Phú Quốc Ocean Breeze',
                'price' => 1250000,
                'address' => 'Bãi Trường, Phú Quốc, Kiên Giang',
                'description' => 'Homestay gần biển với không gian mở, nội thất sáng màu và ban công rộng để ngắm hoàng hôn tuyệt đẹp trên đảo.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200',
                'status' => 'available',
                'capacity' => 3,
                'type' => 'vip',
                'is_featured' => true,
            ],
            [
                'name' => 'CloudStay Sapa Valley Nest',
                'price' => 780000,
                'address' => 'Bản Cát Cát, Sa Pa, Lào Cai',
                'description' => 'Căn phòng ấm áp với view núi và thung lũng, thích hợp cho những ai yêu không khí mộc mạc và thiên nhiên vùng cao.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505693536294-233fb141754c?w=1200',
                'status' => 'available',
                'capacity' => 2,
                'type' => 'double',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Nha Trang Beachfront',
                'price' => 980000,
                'address' => 'Đường Trần Phú, Nha Trang, Khánh Hòa',
                'description' => 'Homestay sát biển với phong cách trẻ trung, thuận tiện di chuyển đến trung tâm thành phố và các bãi tắm nổi tiếng.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'double',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Hà Giang Stone House',
                'price' => 690000,
                'address' => 'Phố cổ Đồng Văn, Hà Giang',
                'description' => 'Không gian mang dấu ấn bản địa, tường đá mộc mạc và ban công nhìn ra phố cổ, lý tưởng cho hành trình khám phá Hà Giang.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?w=1200',
                'status' => 'available',
                'capacity' => 2,
                'type' => 'single',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Vũng Tàu Sunset Villa',
                'price' => 1100000,
                'address' => 'Đường Hạ Long, Vũng Tàu, Bà Rịa - Vũng Tàu',
                'description' => 'Villa mini với tone màu hiện đại, gần biển và có không gian sinh hoạt chung rộng, phù hợp gia đình hoặc nhóm bạn.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200',
                'status' => 'available',
                'capacity' => 5,
                'type' => 'family_suite',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Mộc Châu Hillside',
                'price' => 720000,
                'address' => 'Bản Áng, Mộc Châu, Sơn La',
                'description' => 'Phòng nghỉ ấm cúng giữa đồi chè và rừng thông, mang lại cảm giác nghỉ dưỡng nhẹ nhàng và gần gũi thiên nhiên.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=1200',
                'status' => 'available',
                'capacity' => 3,
                'type' => 'suite',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Huế Garden Retreat',
                'price' => 760000,
                'address' => 'Đường Kim Long, Huế, Thừa Thiên Huế',
                'description' => 'Không gian xanh mát, yên tĩnh với sân vườn rộng, thích hợp cho du khách muốn tận hưởng nét nhẹ nhàng cổ kính của Huế.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505692952047-1a78307da8f2?w=1200',
                'status' => 'available',
                'capacity' => 2,
                'type' => 'single',
                'is_featured' => false,
            ],
            [
                'name' => 'CloudStay Cần Thơ River Home',
                'price' => 830000,
                'address' => 'Bến Ninh Kiều, Cần Thơ',
                'description' => 'Căn phòng thoáng đãng gần sông, thuận tiện trải nghiệm chợ nổi và ẩm thực miền Tây trong không gian thân thiện, dễ chịu.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1464890100898-a385f744067f?w=1200',
                'status' => 'available',
                'capacity' => 4,
                'type' => 'double',
                'is_featured' => false,
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['name' => $room['name']],
                $room
            );
        }
    }
}
