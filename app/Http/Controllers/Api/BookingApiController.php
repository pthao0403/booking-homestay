<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Booking::query()
            ->where('user_id', Auth::id())
            ->with('room')
            ->latest();

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

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
        ]);

        $room = Room::findOrFail($request->room_id);

        if ($request->integer('guests') > $room->capacity) {
            return response()->json([
                'message' => 'So luong khach vuot qua suc chua toi da cua phong.',
            ], 422);
        }

        $checkin = $request->input('check_in');
        $checkout = $request->input('check_out');

        $isOverlapping = Booking::query()
            ->where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkin, $checkout) {
                $query->where('checkin_date', '<', $checkout)
                    ->where('checkout_date', '>', $checkin);
            })
            ->exists();

        if ($isOverlapping) {
            return response()->json([
                'message' => 'Phong da duoc dat trong khoang thoi gian nay.',
            ], 422);
        }

        $checkInDate = Carbon::parse($checkin);
        $checkOutDate = Carbon::parse($checkout);
        $days = max($checkInDate->diffInDays($checkOutDate), 1);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'checkin_date' => $checkin,
            'checkout_date' => $checkout,
            'total_guests' => $request->integer('guests'),
            'total_price' => $days * $room->price,
            'status' => 'pending',
        ]);

        // Gửi email xác nhận đặt phòng (Gmail SMTP)
        try {
            \Illuminate\Support\Facades\Mail::to(Auth::user()->email)->send(new \App\Mail\BookingConfirmationMail($booking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gửi mail xác nhận đặt phòng API thất bại: ' . $e->getMessage());
        }

        // Tạo sự kiện trên Google Calendar
        try {
            if (config('google-calendar.calendar_id')) {
                $event = new \Spatie\GoogleCalendar\Event;
                $event->name = "[Booking API] {$room->name} - Khách: " . Auth::user()->name;
                $event->description = "Email: " . Auth::user()->email . "\nSố lượng: {$request->guests} người\nTổng tiền: " . number_format($days * $room->price) . " VNĐ";
                $event->startDateTime = Carbon::parse($checkin)->setTime(14, 0);
                $event->endDateTime = Carbon::parse($checkout)->setTime(12, 0);
                $event->save();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Tạo Google Calendar event API thất bại: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Dat phong thanh cong.',
            'data' => $booking->load('room'),
        ], 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return response()->json([
            'data' => $booking->load(['room', 'user']),
        ]);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Chi co the huy booking dang cho duyet.',
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'message' => 'Huy booking thanh cong.',
            'data' => $booking,
        ]);
    }
}
