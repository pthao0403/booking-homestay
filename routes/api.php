<?php

use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RoomApiController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'statistics'])->name('api.dashboard');
Route::get('/rooms', [RoomApiController::class, 'index'])->name('api.rooms.index');
Route::get('/rooms/{room}', [RoomApiController::class, 'show'])->name('api.rooms.show');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/bookings', [BookingApiController::class, 'index'])->name('api.bookings.index');
    Route::post('/bookings', [BookingApiController::class, 'store'])->name('api.bookings.store');
    Route::get('/bookings/{booking}', [BookingApiController::class, 'show'])->name('api.bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingApiController::class, 'cancel'])->name('api.bookings.cancel');
});
