@extends('layouts.app')

@section('title', 'Quản lý phòng - CloudStay')

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
                        <span class="section-kicker">Phòng & homestay</span>
                        <h1 class="h3 fw-bold mb-1">Danh sách phòng đang quản lý</h1>
                        <p class="text-muted mb-0">
                            Xem nhanh trạng thái phòng, chỉnh sửa nội dung hiển thị và truy cập trang chi tiết hoặc đặt phòng công khai.
                        </p>
                    </div>

                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Thêm phòng mới
                    </a>
                </div>

                <div class="row g-4">
                    @forelse($rooms as $room)
                        <div class="col-lg-6 col-xxl-4">
                            <article class="admin-room-card h-100">
                                <img
                                    src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                                    alt="{{ $room->name }}"
                                    class="admin-room-image"
                                >

                                <div class="admin-room-content">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <h5 class="fw-bold mb-0">{{ $room->name }}</h5>
                                        <span class="room-status-chip">{{ ucfirst($room->status) }}</span>
                                    </div>

                                    <p class="text-muted mb-2">
                                        <i class="bi bi-geo-alt-fill text-primary"></i> {{ $room->address }}
                                    </p>

                                    <p class="text-muted small mb-3">
                                        {{ \Illuminate\Support\Str::limit($room->description, 110) }}
                                    </p>

                                    <div class="admin-room-meta">
                                        <span><i class="bi bi-cash-stack"></i> {{ number_format((float) $room->price) }} VNĐ / đêm</span>
                                        <span><i class="bi bi-people"></i> {{ $room->capacity }} khách</span>
                                        <span><i class="bi bi-door-open"></i> {{ ucfirst(str_replace('_', ' ', $room->type)) }}</span>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-secondary btn-sm">Xem ngoài site</a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-sm text-white">Chỉnh sửa</a>
                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border text-center mb-0">
                                Chưa có phòng nào trong hệ thống. Hãy tạo phòng đầu tiên để bắt đầu hiển thị trên website.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
