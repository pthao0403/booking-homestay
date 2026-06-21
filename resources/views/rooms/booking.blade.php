@extends('layouts.app')

@section('title', 'Đặt phòng ' . $room->name . ' - CloudStay')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="booking-content shadow-sm">
                <div class="room-summary">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h1 class="h3 mb-1">Đặt phòng {{ $room->name }}</h1>
                            <p class="text-muted mb-0"><i class="bi bi-geo-alt"></i> {{ $room->address }}</p>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Giá mỗi đêm</div>
                            <div class="fs-4 fw-bold text-primary">{{ number_format((float) $room->price) }} VNĐ</div>
                        </div>
                    </div>
                </div>

                @guest
                    <div class="alert alert-warning mb-0">
                        Bạn cần <a href="{{ route('login') }}" class="alert-link">đăng nhập</a> để gửi yêu cầu đặt phòng.
                    </div>
                @else
                    <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label">Ngày nhận phòng</label>
                                <input type="date" id="check_in" name="check_in" class="form-control" value="{{ old('check_in') }}" min="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Ngày trả phòng</label>
                                <input type="date" id="check_out" name="check_out" class="form-control" value="{{ old('check_out') }}" min="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guests" class="form-label">Số lượng khách</label>
                                <input type="number" id="guests" name="guests" min="1" max="{{ $room->capacity }}" class="form-control" value="{{ old('guests', 1) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sức chứa tối đa</label>
                                <input type="text" class="form-control" value="{{ $room->capacity }} khách" disabled>
                            </div>
                        </div>

                        <div class="booking-summary mt-4">
                            Tổng tiền ước tính: <span id="total-price">0</span> VNĐ
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Xác nhận đặt phòng</button>
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-secondary">Quay lại chi tiết phòng</a>
                        </div>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalPriceSpan = document.getElementById('total-price');

        if (!checkInInput || !checkOutInput || !totalPriceSpan) {
            return;
        }

        const pricePerNight = {{ (float) $room->price }};

        function calculatePrice() {
            if (!checkInInput.value || !checkOutInput.value) {
                totalPriceSpan.textContent = '0';
                return;
            }

            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);

            if (checkOut <= checkIn) {
                totalPriceSpan.textContent = '0';
                return;
            }

            const diffTime = checkOut - checkIn;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const total = diffDays * pricePerNight;
            totalPriceSpan.textContent = total.toLocaleString('vi-VN');
        }

        checkInInput.addEventListener('change', calculatePrice);
        checkOutInput.addEventListener('change', calculatePrice);
        calculatePrice();
    });
</script>
@endpush
