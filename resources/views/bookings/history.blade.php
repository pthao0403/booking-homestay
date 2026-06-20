@extends('layouts.app')

@section('title', 'Lịch sử đặt phòng của tôi - CloudStay')

@section('content')
<style>
    .history-container {
        max-width: 900px;
        margin: 2rem auto;
    }
    .history-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        position: relative;
    }
    .history-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #6366f1, #10b981);
        border-radius: 2px;
    }
    .filter-btn-custom {
        padding: 0.5rem 1.25rem;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
        color: #64748b;
        background-color: white;
    }
    .filter-btn-custom:hover,
    .filter-btn-custom.active {
        background-color: #6366f1;
        color: white;
        border-color: #6366f1;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }
    .booking-card-premium {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        background: white;
        transition: all 0.3s;
    }
    .booking-card-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.03) !important;
    }
    .status-badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 30px;
    }
</style>

<div class="history-container container">
    <h2 class="history-title">Lịch Sử Đặt Phòng Của Tôi</h2>
    
    @php
        $currentStatus = request('status', 'all');
    @endphp

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="?status=all" class="filter-btn-custom {{ $currentStatus === 'all' ? 'active' : '' }}">Tất cả</a>
        <a href="?status=upcoming" class="filter-btn-custom {{ $currentStatus === 'upcoming' ? 'active' : '' }}">Sắp tới</a>
        <a href="?status=completed" class="filter-btn-custom {{ $currentStatus === 'completed' ? 'active' : '' }}">Đã hoàn thành</a>
        <a href="?status=cancelled" class="filter-btn-custom {{ $currentStatus === 'cancelled' ? 'active' : '' }}">Đã hủy</a>
    </div>
    
    <div class="bookings-list d-flex flex-column gap-3">
        @forelse($bookings as $booking)
            <div class="card booking-card-premium shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #0f172a;">{{ $booking->room->name }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;"><i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ $booking->room->location }}</p>
                    </div>
                    <div>
                        @if($booking->status === 'pending')
                            <span class="status-badge bg-warning-subtle text-warning border border-warning-subtle">Chờ duyệt</span>
                        @elseif($booking->status === 'confirmed')
                            <span class="status-badge bg-success-subtle text-success border border-success-subtle">Đã xác nhận</span>
                        @elseif($booking->status === 'completed')
                            <span class="status-badge bg-info-subtle text-info border border-info-subtle">Đã hoàn thành</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="status-badge bg-danger-subtle text-danger border border-danger-subtle">Đã hủy</span>
                        @endif
                    </div>
                </div>
                
                <div class="row bg-light p-3 rounded-3 mb-3 text-start">
                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Ngày nhận phòng</span>
                        <strong style="color: #334155;">{{ $booking->check_in ? $booking->check_in->format('d/m/Y') : 'N/A' }}</strong>
                    </div>
                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Ngày trả phòng</span>
                        <strong style="color: #334155;">{{ $booking->check_out ? $booking->check_out->format('d/m/Y') : 'N/A' }}</strong>
                    </div>
                    <div class="col-md-3 col-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Số lượng khách</span>
                        <strong style="color: #334155;">{{ $booking->guests }} người</strong>
                    </div>
                    <div class="col-md-3 col-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem;">Tổng chi phí</span>
                        <strong class="text-primary">{{ number_format((float)$booking->total_price) }} VNĐ</strong>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary btn-sm px-3 py-1.5" style="border-radius: 8px;">Xem hóa đơn chi tiết</a>
                    
                    @if($booking->status === 'pending')
                        <a href="{{ route('bookings.cancel', $booking) }}" class="btn btn-danger btn-sm px-3 py-1.5" style="border-radius: 8px;" onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu đặt phòng này?')">Hủy đặt phòng</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="card p-5 text-center text-muted" style="border-radius: 16px; border: 1px dashed #cbd5e1; background-color: #f8fafc;">
                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #94a3b8;"></i>
                <p class="mt-3 mb-0 fw-semibold">Không tìm thấy yêu cầu đặt phòng nào phù hợp.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
