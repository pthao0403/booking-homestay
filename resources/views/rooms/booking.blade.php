@extends('layouts.app')

@section('title', 'Đặt phòng ' . $room->name . ' - CloudStay')

@section('content')
<div class="booking-container">
    <h1>Đặt phòng {{ $room->name }}</h1>
    
    <div class="booking-content" style="background: #f8f9fa; padding: 2rem; border-radius: 8px; max-width: 600px; margin: 0 auto;">
        <div class="room-summary" style="margin-bottom: 1.5rem; border-bottom: 1px solid #dee2e6; padding-bottom: 1rem;">
            <h3>{{ $room->name }}</h3>
            <p><i class="bi bi-geo-alt"></i> {{ $room->location }}</p>
            <p class="price" style="font-size: 1.2rem; color: #6366f1; font-weight: 600;">{{ number_format($room->price) }} VNĐ / đêm</p>
        </div>
        
        <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            
            <div class="form-group mb-3">
                <label for="check_in" class="form-label">Ngày nhận phòng</label>
                <input type="date" id="check_in" name="check_in" class="form-control" required>
                @error('check_in')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="check_out" class="form-label">Ngày trả phòng</label>
                <input type="date" id="check_out" name="check_out" class="form-control" required>
                @error('check_out')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="guests" class="form-label">Số người đi cùng</label>
                <input type="number" id="guests" name="guests" min="1" max="{{ $room->capacity }}" class="form-control" required>
                @error('guests')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="booking-summary mb-4" style="font-size: 1.3rem; font-weight: bold; border-top: 1px solid #dee2e6; padding-top: 1rem;">
                <p>Tổng tiền ước tính: <span id="total-price" style="color: #ef4444;">0</span> VNĐ</p>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100">Xác nhận đặt phòng</button>
            <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary w-100 mt-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<script>
    // Simple dynamic price script
    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalPriceSpan = document.getElementById('total-price');
        const pricePerNight = {{ $room->price }};

        function calculatePrice() {
            if (checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (checkOut > checkIn) {
                    const total = diffDays * pricePerNight;
                    totalPriceSpan.textContent = total.toLocaleString('vi-VN');
                } else {
                    totalPriceSpan.textContent = '0';
                }
            }
        }

        checkInInput.addEventListener('change', calculatePrice);
        checkOutInput.addEventListener('change', calculatePrice);
    });
</script>
@endsection
