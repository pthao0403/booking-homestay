@extends('layouts.app')

@section('title', 'Chi tiết đặt phòng #' . $booking->id . ' - CloudStay')

@section('content')
<style>
    .invoice-container {
        max-width: 700px;
        margin: 3rem auto;
    }
    .invoice-card {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }
    .invoice-header {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
    }
    .status-pill {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending {
        background-color: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.4);
    }
    .status-confirmed {
        background-color: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.4);
    }
    .status-completed {
        background-color: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.4);
    }
    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.4);
    }
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .total-price-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
</style>

<div class="invoice-container container">
    <div class="card invoice-card shadow">
        <div class="invoice-header">
            <h2 class="fw-bold mb-2">HÓA ĐƠN ĐẶT PHÒNG</h2>
            <p class="mb-0 opacity-75">Mã đặt phòng: <strong>#{{ $booking->id }}</strong></p>
            <p class="mb-0 opacity-75">Ngày đặt: {{ $booking->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="card-body p-4 p-md-5 text-start">
            <div class="text-center mb-4">
                @if($booking->status === 'pending')
                    <span class="status-pill status-pending">Chờ phê duyệt</span>
                @elseif($booking->status === 'confirmed')
                    <span class="status-pill status-confirmed">Đã xác nhận</span>
                @elseif($booking->status === 'completed')
                    <span class="status-pill status-completed">Đã hoàn thành</span>
                @elseif($booking->status === 'cancelled')
                    <span class="status-pill status-cancelled">Đã hủy đặt phòng</span>
                @endif
            </div>

            <h5 class="fw-bold mb-3" style="color: #0f172a;"><i class="bi bi-house-door-fill text-primary me-2"></i>Thông tin phòng</h5>
            <div class="detail-item">
                <span class="text-muted">Tên Homestay</span>
                <span class="fw-semibold text-dark">{{ $booking->room->name }}</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Địa điểm</span>
                <span class="fw-semibold text-dark">{{ $booking->room->location }}</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Giá thuê mỗi đêm</span>
                <span class="fw-semibold text-dark">{{ number_format($booking->room->price) }} VNĐ</span>
            </div>

            <hr class="my-4" style="border-color: #e2e8f0;">

            <h5 class="fw-bold mb-3" style="color: #0f172a;"><i class="bi bi-person-fill-check text-primary me-2"></i>Thông tin chi tiết lưu trú</h5>
            <div class="detail-item">
                <span class="text-muted">Họ tên khách đặt</span>
                <span class="fw-semibold text-dark">{{ $booking->user->name }}</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Email liên hệ</span>
                <span class="fw-semibold text-dark">{{ $booking->user->email }}</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Ngày nhận phòng (Check-in)</span>
                <span class="fw-semibold text-dark">{{ $booking->check_in ? $booking->check_in->format('d/m/Y') : 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Ngày trả phòng (Check-out)</span>
                <span class="fw-semibold text-dark">{{ $booking->check_out ? $booking->check_out->format('d/m/Y') : 'N/A' }}</span>
            </div>

            @php
                $checkIn = \Carbon\Carbon::parse($booking->checkin_date);
                $checkOut = \Carbon\Carbon::parse($booking->checkout_date);
                $nights = $checkIn->diffInDays($checkOut) ?: 1;
            @endphp

            <div class="detail-item">
                <span class="text-muted">Số đêm lưu trú</span>
                <span class="fw-semibold text-dark">{{ $nights }} đêm</span>
            </div>
            <div class="detail-item">
                <span class="text-muted">Số người đi cùng</span>
                <span class="fw-semibold text-dark">{{ $booking->guests }} người</span>
            </div>

            @if($booking->voucher_code || (float) $booking->discount_amount > 0)
                <div class="detail-item">
                    <span class="text-muted">Mã giảm giá</span>
                    <span class="fw-semibold text-dark">{{ $booking->voucher_code ?? 'Không có' }}</span>
                </div>
                <div class="detail-item">
                    <span class="text-muted">Giá gốc</span>
                    <span class="fw-semibold text-dark">{{ number_format((float) $booking->total_price) }} VNĐ</span>
                </div>
                <div class="detail-item">
                    <span class="text-muted">Giảm giá</span>
                    <span class="fw-semibold text-success">-{{ number_format((float) $booking->discount_amount) }} VNĐ</span>
                </div>
            @endif

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-bold text-dark">TỔNG THANH TOÁN</h6>
                    <small class="text-muted">Đã bao gồm tất cả các thuế phí liên quan</small>
                </div>
                <div class="text-end">
                    <span class="fs-3 fw-bold text-danger">{{ number_format((float) $booking->payable_total) }} VNĐ</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ \App\Services\GoogleCalendarService::getAddToCalendarUrl($booking) }}" target="_blank" class="btn btn-outline-danger w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center" style="border-radius: 10px; border-color: #ef4444; color: #ef4444; background: transparent; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='#ef4444';">
                    <i class="bi bi-calendar-plus-fill me-2"></i>Thêm lịch đặt phòng vào Google Calendar
                </a>
            </div>

            <hr class="my-4" style="border-color: #e2e8f0;">

            <div class="d-flex gap-2">
                <a href="{{ route('bookings.index') }}" class="btn btn-primary w-50 py-2.5 fw-semibold d-flex align-items-center justify-content-center" style="border-radius: 10px; min-height: 52px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">Lịch sử đặt phòng</a>
                <a href="{{ route('rooms.index') }}" class="btn btn-primary w-50 py-2.5 fw-semibold d-flex align-items-center justify-content-center" style="border-radius: 10px; min-height: 52px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">Khám phá phòng khác</a>
            </div>
        </div>
    </div>
</div>
@endsection
