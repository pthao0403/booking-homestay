@extends('layouts.app')

@section('title', $room->name . ' - CloudStay')

@section('content')
@php
    $roomTypes = [
        'single' => 'Phòng đơn',
        'double' => 'Phòng đôi',
        'suite' => 'Phòng cao cấp',
        'vip' => 'Phòng VIP',
        'family_suite' => 'Phòng gia đình',
    ];

    $highlights = [
        'Không gian riêng tư, phù hợp nghỉ ngơi thư giãn',
        'Thiết kế gọn gàng, dễ ở và thuận tiện cho nhóm nhỏ',
        'Quy trình đặt phòng rõ ràng, theo dõi trạng thái nhanh chóng',
    ];
@endphp

<div class="container py-4">
    <div class="room-detail-shell">
        <div class="room-detail-topbar mb-4">
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm overflow-hidden room-gallery-card">
                    <img
                        src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                        alt="{{ $room->name }}"
                        class="img-fluid"
                        style="max-height: 560px; object-fit: cover;"
                    >
                </div>

                @if($room->images->isNotEmpty())
                    @include('rooms.gallery')
                @endif

                <div class="card border-0 shadow-sm mt-4 room-info-panel">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Còn trống</span>
                            <span class="badge bg-light text-secondary border">Phù hợp {{ $room->capacity }} khách</span>
                        </div>

                        <h1 class="h2 fw-bold mb-2">{{ $room->name }}</h1>
                        <p class="text-muted fs-6 mb-4">
                            <i class="bi bi-geo-alt-fill text-primary"></i> {{ $room->address }}
                        </p>

                        <div class="room-highlight-grid mb-4">
                            @foreach($highlights as $highlight)
                                <div class="room-highlight-item">
                                    <i class="bi bi-check-circle-fill text-primary"></i>
                                    <span>{{ $highlight }}</span>
                                </div>
                            @endforeach
                        </div>

                        <h2 class="h5 fw-bold">Mô tả chi tiết</h2>
                        <p class="text-muted mb-0">{{ $room->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm room-booking-card">
                    <div class="card-body p-4">
                        <p class="text-uppercase text-primary fw-semibold small mb-2">Thông tin đặt phòng</p>

                        <div class="room-price-block mb-4">
                            <div class="small text-muted">Giá từ</div>
                            <div class="display-6 fw-bold text-primary">{{ number_format((float) $room->price) }} <span class="fs-5">VNĐ</span></div>
                            <div class="text-muted">mỗi đêm</div>
                        </div>

                        <div class="admin-info-card">
                            <div class="admin-info-row">
                                <span>Loại phòng</span>
                                <strong>{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</strong>
                            </div>
                            <div class="admin-info-row">
                                <span>Sức chứa tối đa</span>
                                <strong>{{ $room->capacity }} khách</strong>
                            </div>
                            <div class="admin-info-row">
                                <span>Trạng thái</span>
                                <span class="room-status-chip">Có thể đặt ngay</span>
                            </div>
                            <div class="admin-info-row">
                                <span>Hình ảnh</span>
                                <strong>{{ max($room->images->count(), 1) }} ảnh</strong>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('rooms.booking', $room) }}" class="btn btn-primary btn-lg">Đặt phòng ngay</a>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Xem lịch sử đặt phòng</a>
                        </div>

                        <div class="room-support-note mt-4">
                            <i class="bi bi-headset text-primary"></i>
                            <div>
                                <strong>Hỗ trợ nhanh</strong>
                                <p class="mb-0 text-muted">CloudStay hỗ trợ bạn theo dõi trạng thái booking rõ ràng sau khi gửi yêu cầu đặt phòng.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($similarRooms->isNotEmpty())
                    <div class="card border-0 shadow-sm mt-4 room-related-card">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold mb-3">Homestay tương tự</h2>
                            <div class="d-flex flex-column gap-3">
                                @foreach($similarRooms as $similarRoom)
                                    <a href="{{ route('rooms.show', $similarRoom) }}" class="related-room-link">
                                        <img
                                            src="{{ $similarRoom->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                                            alt="{{ $similarRoom->name }}"
                                        >
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $similarRoom->name }}</h6>
                                            <p class="text-muted small mb-1">{{ $similarRoom->address }}</p>
                                            <strong class="text-primary">{{ number_format((float) $similarRoom->price) }} VNĐ / đêm</strong>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
