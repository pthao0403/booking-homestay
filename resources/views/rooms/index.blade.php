@extends('layouts.app')

@section('title', 'Danh sách phòng - CloudStay')

@section('content')
@php
    $roomTypes = [
        'single' => 'Phòng đơn',
        'double' => 'Phòng đôi',
        'suite' => 'Phòng cao cấp',
        'vip' => 'Phòng VIP',
        'family_suite' => 'Phòng gia đình',
    ];
@endphp

<div class="container py-4">
    <section class="room-list-hero mb-4">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <span class="section-kicker">Kho homestay CloudStay</span>
                <h1 class="mb-2">Danh sách homestay sẵn sàng đón khách</h1>
                <p class="text-muted mb-0">So sánh nhanh giá, sức chứa, loại phòng và chọn homestay phù hợp nhất cho chuyến đi của bạn.</p>
            </div>
            <div class="room-list-hero-stat">
                <strong>{{ $rooms->total() }}</strong>
                <span>phòng khả dụng</span>
            </div>
        </div>
    </section>

    <div class="filters room-filter-panel mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-lg-6">
                <label class="form-label fw-semibold">Từ khóa tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, địa điểm, mô tả..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 col-lg-2">
                <label class="form-label fw-semibold">Nhận phòng</label>
                <input type="date" name="check_in" class="form-control" value="{{ request('check_in') }}">
            </div>
            <div class="col-md-3 col-lg-2">
                <label class="form-label fw-semibold">Trả phòng</label>
                <input type="date" name="check_out" class="form-control" value="{{ request('check_out') }}">
            </div>
            <div class="col-lg-2 d-grid">
                <button type="submit" class="btn btn-primary">Lọc kết quả</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse($rooms as $room)
            <div class="col-lg-4 col-md-6">
                <article class="card room-card room-card-modern room-list-card h-100">
                    <div class="room-card-media">
                        <img
                            src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                            class="room-image w-100"
                            alt="{{ $room->name }}"
                        >
                        <span class="badge bg-primary room-card-badge">{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h5 class="fw-bold mb-0">{{ $room->name }}</h5>
                            <span class="room-status-chip">Còn trống</span>
                        </div>

                        <p class="location text-muted mb-2">
                            <i class="bi bi-geo-alt-fill text-primary"></i> {{ $room->address }}
                        </p>

                        <p class="description text-muted flex-grow-1 mb-3">
                            {{ \Illuminate\Support\Str::limit($room->description, 130) }}
                        </p>

                        <div class="room-card-meta">
                            <span><i class="bi bi-people"></i> {{ $room->capacity }} khách</span>
                            <span><i class="bi bi-images"></i> {{ max($room->images->count(), 1) }} ảnh</span>
                            <span><i class="bi bi-shield-check"></i> Xác nhận nhanh</span>
                        </div>

                        <div class="room-feature-grid mt-4 mb-4">
                            <div class="room-feature-item">
                                <small>Loại phòng</small>
                                <strong>{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</strong>
                            </div>
                            <div class="room-feature-item">
                                <small>Giá mỗi đêm</small>
                                <strong>{{ number_format((float) $room->price) }} VNĐ</strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto gap-2">
                            <span class="price">{{ number_format((float) $room->price) }} VNĐ / đêm</span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                                <a href="{{ route('rooms.booking', $room) }}" class="btn btn-primary btn-sm">Đặt ngay</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center mb-0 empty-state-card">
                    <h5 class="fw-bold mb-2">Không tìm thấy phòng phù hợp</h5>
                    <p class="text-muted mb-0">Hãy thử thay đổi từ khóa tìm kiếm hoặc thời gian lưu trú để xem thêm lựa chọn khác.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
