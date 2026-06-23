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
            $revenue = Booking::query()->sum(DB::raw('COALESCE(final_total, total_price)'));

            $bookingStats = DB::table('bookings')
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

            return response()->json([
                'success' => true,
                'total_rooms' => $totalRooms,
                'total_users' => $totalUsers,
                'total_bookings' => $totalBookings,
                'revenue' => (float) $revenue,
                'formatted_revenue' => number_format((float) $revenue) . ' VNĐ',
                'data' => [
                    'booking_status_stats' => $bookingStats,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tải dữ liệu dashboard lúc này.',
            ], 500);
        }
    }
}
