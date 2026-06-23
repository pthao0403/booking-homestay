<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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

    public function handleForm(Request $request) {
        // Gửi request kiểm tra lên Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LeYGy4tAAAAAO0wIg8dQthlvEqxtNXl6S7c1v6f',
            'response' => $request->input('g-recaptcha-response'),
        ]);

        if (!$response->json()['success']) {
            return back()->withErrors(['captcha' => 'Vui lòng xác minh bạn không phải là người máy!']);
        }
        
        // Tiếp tục xử lý logic đăng nhập/đăng ký...
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
            'voucher_code' => ['nullable', 'string'],
            'discount_amount' => ['nullable', 'numeric'],
            'final_total' => ['nullable', 'numeric'],
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
        $discountAmount = $request->discount_amount ?? 0;
        $finalTotal = $request->final_total ?? $totalPrice;

        if ($finalTotal > $totalPrice || $finalTotal < 0) {
            $finalTotal = $totalPrice;
            $discountAmount = 0;
        }

        // 4. Lưu thông tin đặt phòng
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'checkin_date' => $checkin,
            'checkout_date' => $checkout,
            'total_guests' => $request->guests,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'voucher_code' => $request->voucher_code ? strtoupper($request->voucher_code) : null,
            'discount_amount' => $discountAmount,
            'final_total' => $finalTotal,
        ]);

        // Gửi email xác nhận đặt phòng (Gmail SMTP)
        try {
            \Illuminate\Support\Facades\Mail::to(Auth::user()->email)->send(new \App\Mail\BookingConfirmationMail($booking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gửi mail xác nhận đặt phòng thất bại: ' . $e->getMessage());
        }

        // Tạo sự kiện trên Google Calendar
        try {
            if (config('google-calendar.calendar_id')) {
                $event = new \Spatie\GoogleCalendar\Event;
                $event->name = "[Booking] {$room->name} - Khách: " . Auth::user()->name;
                $event->description = "Email: " . Auth::user()->email .
                    "\nSố lượng: {$request->guests} người" .
                    "\nMã giảm giá: " . ($request->voucher_code ?? 'Không có') .
                    "\nGiảm giá: " . number_format($discountAmount) . " VNĐ" .
                    "\nTổng tiền sau giảm: " . number_format($finalTotal) . " VNĐ";
                $event->startDateTime = Carbon::parse($checkin)->setTime(14, 0);
                $event->endDateTime = Carbon::parse($checkout)->setTime(12, 0);
                $event->save();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Tạo Google Calendar event thất bại: ' . $e->getMessage());
        }

        // ==========================================
        // TỰ ĐỘNG BẮN HOÁ ĐƠN ĐẶT PHÒNG VỀ ZOHO CLIQ
        // ==========================================
        try {
            $zohoCliqUrl = env('ZOHO_CLIQ_WEBHOOK_URL');
            
            if ($zohoCliqUrl) {
                $message = "🔔 *CÓ ĐƠN ĐẶT PHÒNG MỚI CHỜ DUYỆT!*\n"
                         . "• Mã đơn: #" . $booking->id . "\n"
                         . "• Khách hàng: " . Auth::user()->name . "\n"
                         . "• Phòng đặt: " . $room->name . "\n"
                         . "• Tổng tiền: " . number_format($totalPrice) . " VND";

                // Bắn tin nhắn qua ứng dụng chat Zoho Cliq
                // Thêm 'verify' => false để chạy mượt ở localhost không có SSL
                Http::withOptions(['verify' => false])
                    ->post($zohoCliqUrl, [
                        'text' => $message
                    ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi Zoho Cliq: ' . $e->getMessage());
        }
        // ==========================================

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