<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after_or_equal:checkin',
            'guests' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string'
        ]);

        $booking = Booking::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'id' => $booking->id]);
        }

        return redirect()->back()->with('success', 'Yêu cầu đặt phòng đã được gửi.');
    }
}
