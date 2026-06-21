@extends('layouts.app')

@section('title', 'Tìm kiếm phòng - CloudStay')

@section('content')
<div class="rooms-container">
    <h1>Danh sách phòng trống</h1>
    
    <div class="filters">
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Tìm kiếm phòng..." value="{{ request('search') }}">
            <input type="date" name="check_in" placeholder="Ngày nhận phòng" value="{{ request('check_in') }}">
            <input type="date" name="check_out" placeholder="Ngày trả phòng" value="{{ request('check_out') }}">
            <button type="submit" class="btn btn-filter">Lọc</button>
        </form>
    </div>
    
    <div class="rooms-grid">
        @forelse($rooms as $room)
            
            
            <div class="room-card">
                @php
                    $thumb = $room->thumbnail_url;
                    $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';

                    $thumbUrl = null;
                    if ($thumb) {
                        if (is_string($thumb) && str_contains($thumb, '/storage/')) {
                            $filenamePath = preg_replace('#^.*?/storage/#', '', $thumb);
                            $thumbUrl = "https://storage.googleapis.com/booking-homstay/{$filenamePath}";
                        } else {
                            try {
                                $thumbUrl = \Illuminate\Support\Facades\Storage::disk('gcs')->url($thumb);
                            } catch (\Throwable $e) {
                                $thumbUrl = $thumb;
                            }
                        }
                    }
                @endphp
                <div class="room-image" style="background-image: url('{{ $thumbUrl ?: $fallback }}'); background-size: cover; background-position: center; height: 200px;">
                    {{-- Room image --}}
                </div>
                <div class="room-info">
                    <h3>{{ $room->name }}</h3>
                    <p class="location"><i class="bi bi-geo-alt"></i> {{ $room->location }}</p>
                    <p class="description">{{ Str::limit($room->description, 100) }}</p>
                    <div class="room-footer">
                        <span class="price">{{ number_format($room->price) }} VNĐ / đêm</span>
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Không tìm thấy phòng nào trống phù hợp.</p>
        @endforelse
    </div>
    
    {{ $rooms->links() }}
</div>
@endsection
