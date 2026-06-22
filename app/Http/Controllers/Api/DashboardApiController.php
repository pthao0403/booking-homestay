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
            $revenue = DB::table('bookings')
                ->where('status', 'confirmed')
                ->sum('total_price');
        } catch (\Throwable $e) {
            $totalRooms = 0;
            $totalUsers = 0;
            $totalBookings = 0;
            $revenue = 0;
        }

        return response()->json([
            'data' => [
                'total_rooms' => $totalRooms,
                'total_users' => $totalUsers,
                'total_bookings' => $totalBookings,
                'revenue' => (float) $revenue,
                'formatted_revenue' => number_format((float) $revenue) . ' VND',
            ],
        ]);
    }
}
