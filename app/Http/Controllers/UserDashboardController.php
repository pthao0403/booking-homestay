<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        $bookingsQuery = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest();

        $recentBookings = (clone $bookingsQuery)
            ->take(3)
            ->get();

        $stats = [
            'totalBookings' => (clone $bookingsQuery)->count(),
            'pendingBookings' => (clone $bookingsQuery)->where('status', 'pending')->count(),
            'confirmedBookings' => (clone $bookingsQuery)->where('status', 'confirmed')->count(),
            'totalSpent' => (clone $bookingsQuery)
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price'),
        ];

        return view('dashboard.user', [
            'recentBookings' => $recentBookings,
            'stats' => $stats,
        ]);
    }
}
