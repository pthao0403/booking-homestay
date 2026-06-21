@extends('layouts.app')

@section('title', 'Thêm phòng mới - CloudStay')

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
                        <span class="section-kicker">Tạo mới phòng</span>
                        <h1 class="h3 fw-bold mb-1">Thêm homestay vào hệ thống</h1>
                        <p class="text-muted mb-0">Nhập đầy đủ thông tin phòng để hiển thị chuyên nghiệp trên website và khu quản trị.</p>
                    </div>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
                </div>

                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
                    @csrf

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Thông tin phòng</h2>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng</label>
                            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Giá</label>
                            <input type="number" id="price_per_night" name="price_per_night" class="form-control" step="0.01" required value="{{ old('price_per_night') }}">
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Địa chỉ</label>
                            <input type="text" id="location" name="location" class="form-control" required value="{{ old('location') }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea id="description" name="description" rows="7" class="form-control" required>{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="status" class="form-label">Trạng thái</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="available" {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Đang có khách</option>
                                <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            </select>
                        </div>
                    </div>

                    <div class="admin-form-card">
                        <h2 class="h5 fw-bold mb-4">Cấu hình hiển thị</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Sức chứa (người)</label>
                                <input type="number" id="capacity" name="capacity" class="form-control" required value="{{ old('capacity') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="form-label">Loại phòng</label>
                                <select id="type" name="type" class="form-select" required>
                                    <option value="">Chọn loại phòng</option>
                                    <option value="single" {{ old('type') === 'single' ? 'selected' : '' }}>Phòng đơn</option>
                                    <option value="double" {{ old('type') === 'double' ? 'selected' : '' }}>Phòng đôi</option>
                                    <option value="suite" {{ old('type') === 'suite' ? 'selected' : '' }}>Phòng cao cấp (Suite)</option>
                                    <option value="vip" {{ old('type') === 'vip' ? 'selected' : '' }}>Phòng VIP</option>
                                    <option value="family_suite" {{ old('type') === 'family_suite' ? 'selected' : '' }}>Phòng gia đình (Family Suite)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-card admin-form-card-full">
                        <h2 class="h5 fw-bold mb-4">Hình ảnh</h2>
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="thumbnail" class="form-label">Tải ảnh từ máy tính</label>
                                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                            </div>
                            <div class="col-lg-6">
                                <label for="thumbnail_url" class="form-label">Hoặc nhập liên kết ảnh online</label>
                                <input type="text" id="thumbnail_url" name="thumbnail_url" class="form-control" value="{{ old('thumbnail_url') }}" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary">Thêm phòng</button>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
