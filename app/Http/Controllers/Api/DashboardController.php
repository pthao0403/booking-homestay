<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller
{
   public function statistics()
{
    try {
        // 1. Lấy các số liệu tổng (để hiển thị lên 4 ô card phía trên nếu cần)
        $totalRooms = \App\Models\Room::count();
        $totalUsers = \App\Models\User::count();
        $totalBookings = \App\Models\Booking::count();
        
        // Giả sử doanh thu bằng tổng cột 'total_price' hoặc cột tiền của bạn trong bảng bookings
        $revenue = \App\Models\Booking::sum('total_price'); 

        // 2. Lấy dữ liệu phân loại theo trạng thái để vẽ biểu đồ Google Charts
        $bookingStats = \DB::table('bookings')
            ->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 3. Trả về ĐÚNG cấu trúc JSON mà JavaScript đang cần bọc
        return response()->json([
            'success' => true,
            'total_rooms' => $totalRooms,
            'total_users' => $totalUsers,
            'total_bookings' => $totalBookings,
            'revenue' => $revenue,
            'data' => [
                'booking_status_stats' => $bookingStats
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}
