<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/auth/google/mock', [AuthController::class, 'showGoogleMock'])->name('auth.google.mock');
Route::post('/auth/google/mock', [AuthController::class, 'handleGoogleMock'])->name('auth.google.mock.post');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/booking', [RoomController::class, 'booking'])->name('rooms.booking');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::put('/profile', function (Request $request) {
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

    Route::post('/profile/change-password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (Auth::user()->password && !Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    })->name('profile.change-password');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::prefix('admin')->name('admin.')->group(function () {
        $ensureAdmin = function (): void {
            abort_unless(Auth::user()?->role === 'admin', 403, 'Bạn không có quyền truy cập trang quản trị này.');
        };

        Route::get('/dashboard', function () use ($ensureAdmin) {
            $ensureAdmin();

            $totalRooms = Room::count();
            $totalUsers = User::count();

            try {
                $totalBookings = DB::table('bookings')->count();
                $totalRevenue = DB::table('bookings')
                    ->where('status', 'confirmed')
                    ->sum('total_price');
            } catch (\Exception $e) {
                $totalBookings = 0;
                $totalRevenue = 0;
            }

            return view('dashboard.admin', compact('totalRooms', 'totalUsers', 'totalBookings', 'totalRevenue'));
        })->name('dashboard');

        Route::resource('rooms', AdminRoomController::class)->names('rooms');
        Route::post('rooms/{room}/images', [RoomImagesController::class, 'store'])->name('rooms.images.store');
        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::put('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    });
});
