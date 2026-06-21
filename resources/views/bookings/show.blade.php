@extends('layouts.app')

@section('title', 'Chi tiết booking #' . $booking->id . ' - CloudStay')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h1 class="h3 mb-1">Chi tiết booking #{{ $booking->id }}</h1>
                    <p class="mb-0 opacity-75">Ngày tạo: {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <h2 class="h5 fw-bold mb-3">Thông tin homestay</h2>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Tên homestay</small>
                            <strong>{{ $booking->room->name }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Địa điểm</small>
                            <strong>{{ $booking->room->address }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Giá mỗi đêm</small>
                            <strong>{{ number_format((float) $booking->room->price) }} VNĐ</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Người đặt</small>
                            <strong>{{ $booking->user->name }}</strong>
                        </div>
                    </div>

                    <h2 class="h5 fw-bold mb-3">Thông tin lưu trú</h2>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Check-in</small>
                            <strong>{{ optional($booking->checkin_date)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Check-out</small>
                            <strong>{{ optional($booking->checkout_date)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Số khách</small>
                            <strong>{{ $booking->total_guests }}</strong>
                        </div>
                    </div>

                    <div class="alert alert-light border d-flex justify-content-between align-items-center mt-4 mb-0">
                        <span class="fw-semibold">Tổng chi phí</span>
                        <span class="fs-4 fw-bold text-danger">{{ number_format((float) $booking->total_price) }} VNĐ</span>
                    </div>

                    <div class="d-flex gap-2 mt-4 flex-wrap">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Quay lại lịch sử booking</a>
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary">Khám phá phòng khác</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
