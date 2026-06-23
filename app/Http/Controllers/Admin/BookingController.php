<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AdminOnly::class);
    }

    /**
     * Display a listing of all bookings.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang quản trị này.');
        }

        $query = Booking::with(['user', 'room'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update the specified booking status in storage (Confirm booking).
     */
    public function update(Request $request, Booking $booking)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang quản trị này.');
        }

        $request->validate([
            'status' => ['required', 'in:confirmed,cancelled,completed,pending']
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Cập nhật trạng thái đặt phòng thành công!');
    }
}
