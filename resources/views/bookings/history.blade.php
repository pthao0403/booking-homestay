@extends('layouts.app')

@section('title', 'Lịch sử đặt phòng - CloudStay')

@section('content')
<div class="container py-4">
    @php
        $currentStatus = request('status', 'all');
    @endphp

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Lịch sử đặt phòng của tôi</h1>
            <p class="text-muted mb-0">Theo dõi các booking đã gửi, đã duyệt hoặc đã hủy.</p>
        </div>
        <a href="{{ route('rooms.index') }}" class="btn btn-outline-primary">Đặt thêm phòng</a>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('bookings.index', ['status' => 'all']) }}" class="btn btn-sm {{ $currentStatus === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">Tất cả</a>
        <a href="{{ route('bookings.index', ['status' => 'upcoming']) }}" class="btn btn-sm {{ $currentStatus === 'upcoming' ? 'btn-primary' : 'btn-outline-secondary' }}">Sắp tới</a>
        <a href="{{ route('bookings.index', ['status' => 'completed']) }}" class="btn btn-sm {{ $currentStatus === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }}">Đã ở xong</a>
        <a href="{{ route('bookings.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ $currentStatus === 'cancelled' ? 'btn-primary' : 'btn-outline-secondary' }}">Đã hủy</a>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($bookings as $booking)
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h4 class="fw-bold mb-1">{{ $booking->room->name }}</h4>
                            <p class="text-muted mb-0"><i class="bi bi-geo-alt"></i> {{ $booking->room->address }}</p>
                        </div>
                        <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Check-in</small>
                            <strong>{{ optional($booking->checkin_date)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Check-out</small>
                            <strong>{{ optional($booking->checkout_date)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Số khách</small>
                            <strong>{{ $booking->total_guests }}</strong>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Tổng tiền</small>
                            <strong class="text-primary">{{ number_format((float) $booking->total_price) }} VNĐ</strong>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary btn-sm">Xem chi tiết</a>
                        @if($booking->status === 'pending')
                            <a href="{{ route('bookings.cancel', $booking) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy booking này không?')">Hủy booking</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center text-muted">
                    Chưa có booking nào phù hợp với bộ lọc hiện tại.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
