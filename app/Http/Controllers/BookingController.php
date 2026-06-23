<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
// IMPORT THƯ VIỆN GOOGLE CHÍNH CHỦ
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleServiceDrive;
use Google\Service\Drive\DriveFile;

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
                $event->description = "Email: " . Auth::user()->email . "\nSố lượng: {$request->guests} người\nTổng tiền: " . number_format($totalPrice) . " VNĐ";
                $event->startDateTime = Carbon::parse($checkin)->setTime(14, 0);
                $event->endDateTime = Carbon::parse($checkout)->setTime(12, 0);
                $event->save();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Tạo Google Calendar event thất bại: ' . $e->getMessage());
        }

        // ==========================================
        // TÍNH NĂNG ĐỘC LẠ: TỰ ĐỘNG UP HOÁ ĐƠN LÊN GOOGLE DRIVE
        // ==========================================
        try {
            // Khởi tạo file hóa đơn dạng text
            $fileName = 'HoaDon_Booking_' . $booking->id . '_' . now()->format('Ymd_His') . '.txt';
            $fileContent = "=== HOÁ ĐƠN ĐẶT PHÒNG CLOUDSTAY ===\n";
            $fileContent .= "Mã đặt phòng: #" . $booking->id . "\n";
            $fileContent .= "Tên phòng: " . $room->name . "\n";
            $fileContent .= "Khách hàng: " . Auth::user()->name . "\n";
            $fileContent .= "Email: " . Auth::user()->email . "\n";
            $fileContent .= "Thời gian ở: " . $checkin . " đến " . $checkout . " (" . $days . " đêm)\n";
            $fileContent .= "Số lượng khách: " . $request->guests . " người\n";
            $fileContent .= "Tổng tiền thanh toán: " . number_format($totalPrice) . " VND\n";
            $fileContent .= "Trạng thái: Đang chờ duyệt (Pending)\n";
            $fileContent .= "Ngày xuất hóa đơn: " . now()->toDateTimeString() . "\n";

            // Kết nối Google API Client
            $client = new GoogleClient();
            $client->setAuthConfig(storage_path('app/google-service-account.json'));
            $client->addScope(GoogleServiceDrive::DRIVE);
            $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            $driveService = new GoogleServiceDrive($client);

            // Cấu hình metadata để đẩy vào thư mục chỉ định
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')]
            ]);

            // Thực thi upload dữ liệu dạng text thuần lên Drive
            $driveService->files->create($fileMetadata, [
                'data' => $fileContent,
                'mimeType' => 'text/plain',
                'uploadType' => 'multipart',
                'fields' => 'id',
                'supportsAllDrives' => true,
            ]);
        } catch (\Exception $e) {
            // Đưa về dạng ghi log âm thầm như cũ khi chạy thực tế
            \Illuminate\Support\Facades\Log::error('Lỗi upload Google Drive API: ' . $e->getMessage());
        }

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