@extends('layouts.app')

@section('title', 'Danh sách phòng')

@section('content')

<!-- Banner -->
<section class="room-banner mb-5">
    <div class="container text-center text-white">
        <h1 class="fw-bold">Danh Sách Homestay</h1>
        <p>Tìm kiếm nơi nghỉ dưỡng phù hợp cho chuyến đi của bạn</p>
    </div>
</section>

<!-- Search -->
<section class="container mb-5">
    <div class="search-box">
        <div class="row g-3">

            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       placeholder="Tìm theo tên homestay">
            </div>

            <div class="col-md-3">
                <input type="number"
                       class="form-control"
                       placeholder="Giá tối đa">
            </div>

            <div class="col-md-3">
                <select class="form-select">
                    <option>Tất cả trạng thái</option>
                    <option>Available</option>
                    <option>Occupied</option>
                    <option>Maintenance</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Tìm kiếm
                </button>
            </div>

        </div>
    </div>
</section>

<!-- Rooms -->
<section class="container">

    <div class="row">

        @foreach($rooms as $room)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card room-card h-100">

                <img src="{{ $room->thumbnail_url }}"
                     class="card-img-top room-image"
                     alt="{{ $room->name }}">

                <div class="card-body">

                    <h5 class="fw-bold">
                        {{ $room->name }}
                    </h5>

                    <p class="text-primary fw-bold fs-5">
                        {{ number_format($room->price) }} VNĐ / đêm
                    </p>

                    <p>
                        📍 {{ $room->address }}
                    </p>

                    <p class="text-muted">
                        {{ Str::limit($room->description,100) }}
                    </p>

                    @if($room->status == 'Available')

                        <span class="badge bg-success">
                            Còn phòng
                        </span>

                    @elseif($room->status == 'Occupied')

                        <span class="badge bg-danger">
                            Đã thuê
                        </span>

                    @else

                        <span class="badge bg-warning">
                            Bảo trì
                        </span>

                    @endif

                    <div class="mt-3">

                        <a href="/rooms/{{ $room->id }}"
                           class="btn btn-primary w-100">

                            Xem chi tiết

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</section>

@endsection