<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistics(): JsonResponse
    {
        try {
            $totalRooms = Room::count();
            $totalUsers = User::count();
            $totalBookings = Booking::count();
            
            // Ép kiểu doanh thu trực tiếp về dạng số float/int để Javascript không bị lỗi
            $revenue = (float) Booking::query()->where('status', 'confirmed')->sum('total_price');

            $bookingStats = DB::table('bookings')
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

            return response()->json([
                'success' => true,
                'total_rooms' => $totalRooms,
                'total_users' => $totalUsers,
                'total_bookings' => $totalBookings,
                'revenue' => $revenue, // Trả về số: 31100000
                'formatted_revenue' => number_format($revenue) . ' VNĐ',
                'booking_status_stats' => $bookingStats, // Đẩy thẳng ra ngoài cho Javascript dễ đọc
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi API Dashboard: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Không thể tải dữ liệu dashboard lúc này.',
            ], 500);
        }
    }
}