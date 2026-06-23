<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomImagesController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VoucherController;
use App\Services\VoucherSheetService;

// Home Page
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Login & Mock Login Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/auth/google/mock', [AuthController::class, 'showGoogleMock'])->name('auth.google.mock');
Route::post('/auth/google/mock', [AuthController::class, 'handleGoogleMock'])->name('auth.google.mock.post');

// Public Room Routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/booking', [RoomController::class, 'booking'])->name('rooms.booking');

// Public Booking Routes (Customer)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', UserDashboardController::class)->name('dashboard');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Authentication Routes
Route::get('/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['auth'])->group(function () {
    // Admin Dashboard Route
    Route::get('/admin/dashboard', function () {
        $totalRooms = Room::count();
        $totalUsers = User::count();
        $totalVouchers = count(app(VoucherSheetService::class)->all());
        $activeVouchers = app(VoucherSheetService::class)->countActive();
        $expiredVouchers = app(VoucherSheetService::class)->countExpired();
        try {
            $totalBookings = DB::table('bookings')->count();
            $revenue = DB::table('bookings')
                ->where('status', 'confirmed')
                ->sum(DB::raw('COALESCE(final_total, total_price)'));
        } catch (\Exception $e) {
            $totalBookings = 0;
            $revenue = 0;
        }

        // Format revenue as VNĐ
        $revenue = number_format($revenue) . ' VNĐ';

        return view('admin.dashboard', compact('totalRooms', 'totalUsers', 'totalBookings', 'revenue', 'totalVouchers', 'activeVouchers', 'expiredVouchers'));
    })->name('admin.dashboard');
    Route::get('/admin/google-vouchers', function (VoucherSheetService $voucherSheetService) {
        $vouchers = array_map(function (array $voucher) use ($voucherSheetService): array {
            $voucher['label'] = $voucherSheetService->formatDiscount($voucher);

            return $voucher;
        }, $voucherSheetService->all());

        $activeVouchers = array_values(array_filter($vouchers, fn (array $voucher): bool => $voucher['status'] === 'active'));
        $expiredVouchers = array_values(array_filter($vouchers, fn (array $voucher): bool => $voucher['status'] === 'expired'));

        return view('admin.google-vouchers', [
            'vouchers' => $vouchers,
            'activeCount' => count($activeVouchers),
            'expiredCount' => count($expiredVouchers),
            'manageSheetUrl' => $voucherSheetService->manageSheetUrl(),
            'publicSheetUrl' => $voucherSheetService->publicSheetUrl(),
        ]);
    })->name('admin.google-vouchers');

    // Admin Room CRUD Routes
    Route::resource('admin/rooms', AdminRoomController::class)->names('admin.rooms');

    // Admin Room Images Upload
    Route::post('admin/rooms/{room}/images', [\App\Http\Controllers\Admin\RoomImagesController::class, 'store'])
        ->name('admin.rooms.images.store');

    // Delete a room image
    Route::delete('admin/rooms/{room}/images/{image}', [\App\Http\Controllers\Admin\RoomImagesController::class, 'destroy'])
        ->name('admin.rooms.images.destroy');


    // Admin Booking Management Routes
    Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::put('/admin/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
});


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    })->name('profile.update');

    Route::post('/profile/change-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (Auth::user()->password && !\Illuminate\Support\Facades\Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        Auth::user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    })->name('profile.change-password');
});
// Voucher Check Route
Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
Route::post(
    '/voucher/check',
    [VoucherController::class,'check']
)->name('voucher.check');
