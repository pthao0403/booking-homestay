<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Room Routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/booking', [RoomController::class, 'booking'])->name('rooms.booking');

// Admin Room CRUD Routes
Route::resource('admin/rooms', AdminRoomController::class)->names('admin.rooms');

// Placeholder routes to prevent sidebar template crashes
Route::get('/admin/dashboard', function () {
    $totalRooms = Room::count();
    $totalUsers = User::count();
    try {
        $totalBookings = DB::table('bookings')->count();
        $revenue = DB::table('bookings')->where('status', 'confirmed')->sum('total_price');
    } catch (\Exception $e) {
        $totalBookings = 0;
        $revenue = 0;
    }
    
    // Format revenue as VNĐ
    $revenue = number_format($revenue) . ' VNĐ';
    
    return view('admin.dashboard', compact('totalRooms', 'totalUsers', 'totalBookings', 'revenue'));
})->name('admin.dashboard');

Route::get('/admin/bookings', function () {
    return 'Quản lý Đặt phòng (Placeholder)';
})->name('admin.bookings.index');

Route::get('/profile', function () {
    return 'Trang cá nhân';
})->name('profile.index');

Route::post('/logout', function () {
    return 'Đăng xuất';
})->name('logout');

// Placeholder for booking store (due on June 21st)
Route::post('/bookings', function () {
    return 'Đặt phòng thành công (Placeholder)';
})->name('bookings.store');

