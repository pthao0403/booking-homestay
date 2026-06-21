@extends('layouts.app')

@section('title', $room->name . ' - CloudStay')

@section('content')
<div class="room-detail-container">
    <div class="room-detail-header">
        <h1>{{ $room->name }}</h1>
        <p class="location"><i class="bi bi-geo-alt"></i> {{ $room->location }}</p>
    </div>
    
    <div class="room-detail-content">
        <div class="room-images" style="margin-bottom: 2rem;">
            <img src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500' }}" alt="{{ $room->name }}" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px;">
        </div>

        @include('rooms.gallery')

        
        <div class="room-details">
            <h2>Thông tin chi tiết</h2>
            <p class="description">{{ $room->description }}</p>
            
            <div class="details-info" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0;">
                <p><strong>Giá:</strong> {{ number_format($room->price) }} VNĐ / đêm</p>
                <p><strong>Sức chứa tối đa:</strong> {{ $room->capacity }} người</p>
                <p><strong>Loại phòng:</strong> 
                    @php
                        $roomTypes = [
                            'single' => 'Phòng đơn',
                            'double' => 'Phòng đôi',
                            'suite' => 'Phòng cao cấp (Suite)',
                            'vip' => 'Phòng VIP',
                            'family_suite' => 'Phòng Gia đình (Family Suite)'
                        ];
                    @endphp
                    {{ $roomTypes[$room->type] ?? ucfirst($room->type) }}
                </p>
                <p><strong>Trạng thái:</strong> <span class="badge bg-success">{{ $room->status }}</span></p>
            </div>
            
            <div class="booking-section">
                <a href="{{ route('rooms.booking', $room) }}" class="btn btn-primary btn-lg">Đặt phòng ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection
