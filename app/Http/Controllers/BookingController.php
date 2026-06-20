<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{


    /**
     * Display a listing of the user's bookings.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Booking::where('user_id', $user->id)->with('room')->latest();

        $status = $request->input('status', 'all');
        $today = Carbon::today()->toDateString();

        if ($status === 'upcoming') {
            $query->where('status', '!=', 'cancelled')
                  ->where('checkin_date', '>=', $today);
        } elseif ($status === 'completed') {
            $query->where('status', '!=', 'cancelled')
                  ->where('checkout_date', '<', $today);
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        $bookings = $query->get();

        return view('bookings.history', compact('bookings'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
        ]);

        $room = Room::findOrFail($request->room_id);

        // 1. Kiểm tra sức chứa
        if ($request->guests > $room->capacity) {
            return back()->withErrors([
                'guests' => 'Số lượng khách vượt quá sức chứa tối đa của phòng (' . $room->capacity . ' người).',
            ])->withInput();
        }

        // 2. Chống trùng lịch đặt phòng (Overlap check)
        $checkin = $request->check_in;
        $checkout = $request->check_out;

        $isOverlapping = Booking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkin, $checkout) {
                $query->where('checkin_date', '<', $checkout)
                      ->where('checkout_date', '>', $checkin);
            })
            ->exists();

        if ($isOverlapping) {
            return back()->withErrors([
                'check_out' => 'Phòng đã được đặt trong khoảng thời gian này. Vui lòng chọn thời gian khác.',
            ])->withInput();
        }

        // 3. Tính toán tổng chi phí
        $checkInDate = Carbon::parse($checkin);
        $checkOutDate = Carbon::parse($checkout);
        $days = $checkInDate->diffInDays($checkOutDate);
        if ($days <= 0) {
            $days = 1; // Tối thiểu 1 đêm
        }
        $totalPrice = $days * $room->price;

        // 4. Lưu thông tin đặt phòng
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'checkin_date' => $checkin,
            'checkout_date' => $checkout,
            'total_guests' => $request->guests,
            'total_price' => $totalPrice,
            'status' => 'pending', // Chờ xử lý/duyệt
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Đặt phòng thành công! Yêu cầu của bạn đang chờ phê duyệt.');
    }

    /**
     * Display the specified booking detail.
     */
    public function show(Booking $booking)
    {
        // Đảm bảo người dùng chỉ xem được booking của chính họ (trừ khi là admin)
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập thông tin đặt phòng này.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Booking $booking)
    {
        // Đảm bảo người dùng chỉ hủy được booking của chính họ
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Bạn không có quyền hủy đặt phòng này.');
        }

        // Chỉ cho phép hủy khi đang ở trạng thái pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy phòng khi ở trạng thái chờ phê duyệt.');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Hủy phòng thành công!');
    }
}
