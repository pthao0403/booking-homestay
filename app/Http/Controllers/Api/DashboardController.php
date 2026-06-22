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
        return response()->json([
            'total_rooms' => Room::count(),
            'total_bookings' => Booking::count(),
            'total_users' => User::count(),
        ]);
    }
}