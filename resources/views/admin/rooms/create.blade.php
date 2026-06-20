@extends('layouts.app')

@section('title', 'Thêm phòng mới - CloudStay')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')
    
    <div class="admin-content">
        <h1>Thêm phòng mới</h1>
        
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Tên phòng</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="location">Địa chỉ</label>
                <input type="text" id="location" name="location" required value="{{ old('location') }}">
                @error('location')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price_per_night">Giá mỗi đêm (VNĐ)</label>
                <input type="number" id="price_per_night" name="price_per_night" step="0.01" required value="{{ old('price_per_night') }}">
                @error('price_per_night')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="capacity">Sức chứa (Người)</label>
                <input type="number" id="capacity" name="capacity" required value="{{ old('capacity') }}">
                @error('capacity')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="type">Loại phòng</label>
                <select id="type" name="type" required>
                    <option value="">Chọn loại phòng</option>
                    <option value="single">Phòng đơn</option>
                    <option value="double">Phòng đôi</option>
                    <option value="suite">Phòng cao cấp (Suite)</option>
                    <option value="vip">Phòng VIP</option>
                    <option value="family_suite">Phòng Gia đình (Family Suite)</option>
                </select>
                @error('type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="thumbnail">Tải lên ảnh từ máy tính (Thumbnail)</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                @error('thumbnail')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail_url">Hoặc nhập liên kết ảnh online (URL)</label>
                <input type="text" id="thumbnail_url" name="thumbnail_url" value="{{ old('thumbnail_url') }}" placeholder="https://example.com/image.jpg">
                @error('thumbnail_url')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Thêm phòng</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection
