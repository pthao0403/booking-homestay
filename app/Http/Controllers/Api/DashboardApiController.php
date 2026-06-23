<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $totalRooms = Room::count();
            $totalUsers = User::count();
            $totalBookings = DB::table('bookings')->count();
            
            // Sửa đổi: Chỉ tính tổng tiền dựa trên cột total_price chuẩn của bạn
            $revenue = (float) DB::table('bookings')
                ->where('status', 'confirmed')
                ->sum('total_price');

            // Trả về cấu trúc phẳng khớp hoàn toàn với các biến mappings trong Javascript file Blade
            return response()->json([
                'success' => true,
                'total_rooms' => $totalRooms,
                'total_users' => $totalUsers,
                'total_bookings' => $totalBookings,
                'revenue' => $revenue,
                'formatted_revenue' => number_format($revenue) . ' VNĐ',
            ]);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi DashboardApiController: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xử lý dữ liệu hệ thống.',
            ], 500);
        }
    }
}