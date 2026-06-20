@extends('layouts.app')

@section('title', 'Sửa phòng - CloudStay')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')
    
    <div class="admin-content">
        <h1>Sửa thông tin phòng</h1>
        
        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Tên phòng</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $room->name) }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="location">Địa chỉ</label>
                <input type="text" id="location" name="location" required value="{{ old('location', $room->location) }}">
                @error('location')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" rows="5" required>{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price_per_night">Giá mỗi đêm (VNĐ)</label>
                <input type="number" id="price_per_night" name="price_per_night" step="0.01" required value="{{ old('price_per_night', $room->price_per_night) }}">
                @error('price_per_night')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="capacity">Sức chứa (Người)</label>
                <input type="number" id="capacity" name="capacity" required value="{{ old('capacity', $room->capacity) }}">
                @error('capacity')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="type">Loại phòng</label>
                <select id="type" name="type" required>
                    <option value="single" {{ old('type', $room->type) === 'single' ? 'selected' : '' }}>Phòng đơn</option>
                    <option value="double" {{ old('type', $room->type) === 'double' ? 'selected' : '' }}>Phòng đôi</option>
                    <option value="suite" {{ old('type', $room->type) === 'suite' ? 'selected' : '' }}>Phòng cao cấp (Suite)</option>
                    <option value="vip" {{ old('type', $room->type) === 'vip' ? 'selected' : '' }}>Phòng VIP</option>
                    <option value="family_suite" {{ old('type', $room->type) === 'family_suite' ? 'selected' : '' }}>Phòng Gia đình (Family Suite)</option>
                </select>
                @error('type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="thumbnail">Tải lên ảnh mới từ máy tính (Thumbnail)</label>
                @if($room->thumbnail_url)
                    <div class="mb-2">
                        <img src="{{ $room->thumbnail_url }}" alt="Current Image" style="height: 100px; border-radius: 4px; object-fit: cover;">
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                @error('thumbnail')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail_url">Hoặc nhập liên kết ảnh online mới (URL)</label>
                <input type="text" id="thumbnail_url" name="thumbnail_url" value="{{ old('thumbnail_url', $room->thumbnail_url) }}" placeholder="https://example.com/image.jpg">
                @error('thumbnail_url')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection
