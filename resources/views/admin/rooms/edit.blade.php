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
                    @php
                        $thumbnailPreview = $room->thumbnail_url;

                        if ($thumbnailPreview && !str_starts_with($thumbnailPreview, 'http')) {
                            $gcsBaseUrl = rtrim((string) config('filesystems.disks.gcs.url'), '/');

                            if ($gcsBaseUrl !== '') {
                                $thumbnailPreview = $gcsBaseUrl . '/' . ltrim($thumbnailPreview, '/');
                            }
                        }
                    @endphp
                    <div class="mb-2">
                        <img src="{{ $thumbnailPreview }}" alt="Current Image" style="height: 100px; border-radius: 4px; object-fit: cover;">
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
            
            <hr style="margin: 1.5rem 0;" />

            <div class="form-group">
                <label for="images">Tải lên ảnh phòng (nhiều ảnh)</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
            </div>

            {{-- Gallery + Delete actions --}}
            @php
                $images = $room->images()->get();
            @endphp

            @if($images->count() > 0)
                <div class="form-group" style="margin-top: 1.25rem;">
                    <h3 style="margin: 0 0 0.75rem;">Danh sách ảnh phòng</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px;">
                        @foreach($images as $img)
                            <div style="border-radius: 8px; overflow: hidden; background: #f2f2f2; position: relative;">
                                <img
                                    class="room-gallery-img"
                                    data-path="{{ $img->image_url }}"
                                    src=""
                                    alt="{{ $room->name }}"
                                    style="width: 100%; height: 140px; object-fit: cover; display:block;"
                                />

                                <form method="POST" action="{{ route('admin.rooms.images.destroy', [$room, $img]) }}"
                                      onsubmit="return confirm('Xóa ảnh này?');"
                                      style="position:absolute; top:8px; right:8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <script data-room-id="{{ $room->id }}">
                    (function () {
                        const roomId = Number(document.currentScript?.dataset.roomId || 0);

                        async function loadSignedUrl(img) {
                            const path = img.dataset.path;
                            if (!path) return;

                            try {
                                const url = new URL(window.location.origin + '/admin/rooms/' + roomId + '/images/signed-url');
                                url.searchParams.set('path', path);

                                const res = await fetch(url.toString(), {
                                    method: 'GET',
                                    headers: { 'Accept': 'application/json' }
                                });

                                const data = await res.json();
                                if (data && data.success && data.url) {
                                    img.src = data.url;
                                }
                            } catch (e) {
                                // keep empty
                            }
                        }

                        document.querySelectorAll('.room-gallery-img').forEach(function (img) {
                            loadSignedUrl(img);
                        });
                    })();
                </script>
            @endif

            <button type="submit" formaction="{{ route('admin.rooms.update', $room) }}" class="btn btn-primary">Cập nhật</button>
            <button type="submit" formaction="{{ route('admin.rooms.images.store', $room) }}" class="btn btn-success">Upload ảnh</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Hủy bỏ</a>

        </form>
    </div>
</div>
@endsection
