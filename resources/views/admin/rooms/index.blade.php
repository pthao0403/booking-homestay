@extends('layouts.app')

@section('content')

<h2>Quản lý phòng</h2>

<div class="mb-4">
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">Thêm phòng mới</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row">

@foreach($rooms as $room)

<div class="col-lg-4 mb-4">

    <div class="card h-100">

        @php
            $thumb = $room->thumbnail_url;
            $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';

            $thumbUrl = null;
            if ($thumb) {
                // If currently stored as a local asset like: http://127.0.0.1:8000/storage/rooms/xxx.jpg
                if (is_string($thumb) && str_contains($thumb, '/storage/')) {
                    $filenamePath = preg_replace('#^.*?/storage/#', '', $thumb);
                    $thumbUrl = "https://storage.googleapis.com/booking-homstay/{$filenamePath}";
                } else {
                    // If already an object path or a full URL, try Storage::disk('gcs')->url() first
                    try {
                        $thumbUrl = \Illuminate\Support\Facades\Storage::disk('gcs')->url($thumb);
                    } catch (\Throwable $e) {
                        $thumbUrl = $thumb;
                    }
                }
            }
        @endphp
        <img src="{{ $thumbUrl ?: $fallback }}"
             class="card-img-top" style="height: 200px; object-fit: cover;">

        <div class="card-body">

            <h5>{{ $room->name }}</h5>

            <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $room->address }}</p>

            <p>
                <strong>Giá:</strong> {{ number_format($room->price) }} VNĐ / đêm
            </p>
            
            <p>
                <strong>Sức chứa:</strong> {{ $room->capacity }} người | 
                <strong>Loại:</strong> 
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

            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('rooms.show', $room->id) }}"
                   class="btn btn-outline-primary btn-sm">
                    Xem
                </a>
                
                <div>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}"
                       class="btn btn-warning btn-sm">
                        Sửa
                    </a>
                    
                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

@endforeach

</div>


@endsection