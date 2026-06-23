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
                <div id="address-suggestions"></div>
                @error('location')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
            
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

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIMINA/AqTMRgpP_TAkM+lNuPPpbjJhEgVw="
    crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
<style>
    #address-suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        background-color: white;
        z-index: 1000;
        width: calc(100% - 24px);
    }
    #address-suggestions div {
        padding: 8px;
        cursor: pointer;
    }
    #address-suggestions div:hover {
        background-color: #f0f0f0;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationInput = document.getElementById('location');
    const suggestionsContainer = document.getElementById('address-suggestions');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    let debounceTimer;

    locationInput.addEventListener('keyup', function() {
        clearTimeout(debounceTimer);
        const query = locationInput.value;

        if (query.length < 3) {
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    if (data.features && data.features.length > 0) {
                        suggestionsContainer.style.display = 'block';
                        data.features.forEach(feature => {
                            const suggestionDiv = document.createElement('div');
                            suggestionDiv.textContent = feature.properties.name + (feature.properties.city ? ', ' + feature.properties.city : '') + (feature.properties.country ? ', ' + feature.properties.country : '');
                            suggestionDiv.addEventListener('click', function() {
                                locationInput.value = this.textContent;
                                suggestionsContainer.innerHTML = '';
                                suggestionsContainer.style.display = 'none';
                                
                                // Geocode with Nominatim
                                fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(locationInput.value)}&format=jsonv2&limit=1`)
                                    .then(response => response.json())
                                    .then(geoData => {
                                        if (geoData && geoData.length > 0) {
                                            latitudeInput.value = geoData[0].lat;
                                            longitudeInput.value = geoData[0].lon;
                                        }
                                    });
                            });
                            suggestionsContainer.appendChild(suggestionDiv);
                        });
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (e.target.id !== 'location') {
            suggestionsContainer.style.display = 'none';
        }
    });
});
</script>
@endpush
