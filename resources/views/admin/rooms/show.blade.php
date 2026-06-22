@extends('layouts.app')

@section('content')

<h2>{{ $room->name }}</h2>

<div class="row">

    <div class="col-md-8">
        @php
            $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';
            $thumbUrl = $fallback;
            
            if ($room->thumbnail_url) {
                if (is_string($room->thumbnail_url) && str_contains($room->thumbnail_url, '/storage/')) {
                    $filenamePath = preg_replace('#^.*?/storage/#', '', $room->thumbnail_url);
                    $thumbUrl = "https://storage.googleapis.com/booking-homstay/{$filenamePath}";
                } else {
                    try {
                        $thumbUrl = \Illuminate\Support\Facades\Storage::disk('gcs')->url($room->thumbnail_url);
                    } catch (\Throwable $e) {
                        $thumbUrl = $room->thumbnail_url;
                    }
                }
            }
        @endphp
        <img src="{{ $thumbUrl }}" class="img-fluid rounded" style="width: 100%; height: 350px; object-fit: cover;">
             class="img-fluid rounded">

        <p class="mt-3">
            {{ $room->description }}
        </p>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body">

                <h4>
                    {{ number_format($room->price) }}
                    VNĐ
                </h4>

                <a href="/booking/{{$room->id}}"
                   class="btn btn-success w-100">
                    Đặt phòng
                </a>

            </div>

        </div>

    </div>

</div>

@endsection