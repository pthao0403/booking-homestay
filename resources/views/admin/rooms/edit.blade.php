@extends('layouts.app')

@section('title', 'Chỉnh sửa phòng - CloudStay')

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
                        <span class="section-kicker">Cập nhật thông tin</span>
                        <h1 class="h3 fw-bold mb-1">Chỉnh sửa phòng {{ $room->name }}</h1>
                        <p class="text-muted mb-0">Cập nhật đầy đủ thông tin phòng và hình ảnh hiển thị trong hệ thống.</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
                    </div>
                </div>

                <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Thông tin phòng</h2>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng</label>
                            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name', $room->name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Giá</label>
                            <input type="number" id="price_per_night" name="price_per_night" class="form-control" step="0.01" required value="{{ old('price_per_night', $room->price_per_night) }}">
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Địa chỉ</label>
                            <input type="text" id="location" name="location" class="form-control" required value="{{ old('location', $room->location) }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea id="description" name="description" rows="7" class="form-control" required>{{ old('description', $room->description) }}</textarea>
                        </div>

                        <div>
                            <label for="status" class="form-label">Trạng thái</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Đang có khách</option>
                                <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            </select>
                        </div>
                    </div>

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Cấu hình hiển thị</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Sức chứa (người)</label>
                                <input type="number" id="capacity" name="capacity" class="form-control" required value="{{ old('capacity', $room->capacity) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="form-label">Loại phòng</label>
                                <select id="type" name="type" class="form-select" required>
                                    <option value="single" {{ old('type', $room->type) === 'single' ? 'selected' : '' }}>Phòng đơn</option>
                                    <option value="double" {{ old('type', $room->type) === 'double' ? 'selected' : '' }}>Phòng đôi</option>
                                    <option value="suite" {{ old('type', $room->type) === 'suite' ? 'selected' : '' }}>Phòng cao cấp (Suite)</option>
                                    <option value="vip" {{ old('type', $room->type) === 'vip' ? 'selected' : '' }}>Phòng VIP</option>
                                    <option value="family_suite" {{ old('type', $room->type) === 'family_suite' ? 'selected' : '' }}>Phòng gia đình (Family Suite)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Hình ảnh đại diện</h2>
                        @if($room->thumbnail_url)
                            <img src="{{ $room->thumbnail_url }}" alt="{{ $room->name }}" class="img-fluid rounded-4 shadow-sm mb-3" style="max-height: 220px; object-fit: cover;">
                        @else
                            <div class="alert alert-light border">Phòng này chưa có ảnh đại diện.</div>
                        @endif

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Tải ảnh đại diện mới từ máy tính</label>
                            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                        </div>

                        <div>
                            <label for="thumbnail_url" class="form-label">Hoặc nhập liên kết ảnh mới</label>
                            <input type="text" id="thumbnail_url" name="thumbnail_url" class="form-control" value="{{ old('thumbnail_url', $room->thumbnail_url) }}" placeholder="https://example.com/image.jpg">
                        </div>
                    </div>

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Bộ sưu tập hình ảnh</h2>
                        <div class="mb-3">
                            <label for="images" class="form-label">Tải thêm nhiều ảnh</label>
                            <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                        </div>
                        <p class="text-muted small mb-0">Bạn có thể cập nhật thông tin phòng hoặc tải thêm hình ảnh ngay tại đây.</p>
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        <button type="submit" formaction="{{ route('admin.rooms.images.store', $room) }}" class="btn btn-success">Tải thêm ảnh</button>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
