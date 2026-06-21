@extends('layouts.app')

@section('title', $room->name . ' - Quản trị CloudStay')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-xl-3">
            @include('partials.sidebar-admin')
        </div>

        <div class="col-xl-9">
            <div class="admin-section-card">
                <div class="admin-section-header">
                    <div>
                        <span class="section-kicker">Chi tiết phòng</span>
                        <h1 class="h3 fw-bold mb-1">{{ $room->name }}</h1>
                        <p class="text-muted mb-0">Xem đầy đủ thông tin phòng đang hiển thị trong hệ thống.</p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-primary">Chỉnh sửa</a>
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-secondary">Xem ngoài site</a>
                    </div>
                </div>

                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <img
                            src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                            alt="{{ $room->name }}"
                            class="img-fluid rounded-4 shadow-sm w-100"
                            style="max-height: 480px; object-fit: cover;"
                        >

                        <div class="mt-4">
                            <h2 class="h5 fw-bold">Mô tả</h2>
                            <p class="text-muted mb-0">{{ $room->description }}</p>
                        </div>

                        @include('rooms.gallery')
                    </div>

                    <div class="col-lg-5">
                        <div class="admin-info-card">
                            <h2 class="h5 fw-bold mb-3">Thông tin phòng</h2>

                            <div class="admin-info-row">
                                <span>Tên phòng</span>
                                <strong>{{ $room->name }}</strong>
                            </div>
                            <div class="admin-info-row">
                                <span>Giá</span>
                                <strong>{{ number_format((float) $room->price) }} VNĐ</strong>
                            </div>
                            <div class="admin-info-row">
                                <span>Địa chỉ</span>
                                <strong>{{ $room->address }}</strong>
                            </div>
                            <div class="admin-info-row">
                                <span>Trạng thái</span>
                                <span class="room-status-chip">
                                    @if($room->status === 'available')
                                        Còn trống
                                    @elseif($room->status === 'occupied')
                                        Đang có khách
                                    @else
                                        Bảo trì
                                    @endif
                                </span>
                            </div>
                            <div class="admin-info-row">
                                <span>Hình ảnh</span>
                                <strong>{{ max($room->images()->count(), 1) }} ảnh</strong>
                            </div>
                        </div>

                        <div class="admin-feature-card mt-4">
                            <h2 class="h5 fw-bold">Thao tác nhanh</h2>
                            <p class="text-muted">Đi đến trang chỉnh sửa hoặc kiểm tra trải nghiệm đặt phòng phía người dùng.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-primary">Sửa thông tin phòng</a>
                                <a href="{{ route('rooms.booking', $room) }}" class="btn btn-outline-success">Thử luồng đặt phòng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
