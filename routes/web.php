<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Room CRUD Routes
Route::resource('admin/rooms', AdminRoomController::class)->names('admin.rooms');

// Admin Booking Management Routes
Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
Route::put('/admin/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');

// Admin Dashboard Route
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

// Placeholder for profile
Route::get('/profile', function () {
    return 'Trang cá nhân';
})->name('profile.index');


