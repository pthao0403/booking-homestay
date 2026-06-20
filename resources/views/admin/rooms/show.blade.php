@extends('layouts.app')

@section('title', $room->name)

@section('content')

<!-- Banner -->

<section class="room-detail-banner">

    <div class="container">

        <h1 class="text-white fw-bold">
            {{ $room->name }}
        </h1>

        <p class="text-white">
            📍 {{ $room->address }}
        </p>

    </div>

</section>

<!-- Content -->

<section class="container py-5">

    <div class="row">

        <!-- LEFT -->

        <div class="col-lg-8">

            <!-- Gallery -->

            <div class="gallery-wrapper mb-4">

                <img src="{{ $room->thumbnail_url }}"
                     class="main-image">

            </div>

            @if(isset($room->images))

            <div class="row mb-4">

                @foreach($room->images as $image)

                <div class="col-md-3 mb-3">

                    <img src="{{ $image->image_url }}"
                         class="gallery-thumb">

                </div>

                @endforeach

            </div>

            @endif

            <!-- Description -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h3>Mô tả phòng</h3>

                    <p>
                        {{ $room->description }}
                    </p>

                </div>

            </div>

            <!-- Amenities -->

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h3>Tiện nghi</h3>

                    <div class="row">

                        <div class="col-md-4">
                            ✅ Wifi miễn phí
                        </div>

                        <div class="col-md-4">
                            ✅ Điều hòa
                        </div>

                        <div class="col-md-4">
                            ✅ TV thông minh
                        </div>

                        <div class="col-md-4">
                            ✅ Hồ bơi
                        </div>

                        <div class="col-md-4">
                            ✅ Chỗ đậu xe
                        </div>

                        <div class="col-md-4">
                            ✅ Bữa sáng
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-4">

            <div class="booking-card">

                <h2 class="text-primary">

                    {{ number_format($room->price) }}

                    VNĐ

                </h2>

                <p>/ đêm</p>

                <hr>

                <form>

                    <div class="mb-3">

                        <label>
                            Ngày nhận phòng
                        </label>

                        <input type="date"
                               class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>
                            Ngày trả phòng
                        </label>

                        <input type="date"
                               class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>
                            Số khách
                        </label>

                        <select class="form-select">

                            <option>1 khách</option>
                            <option>2 khách</option>
                            <option>3 khách</option>
                            <option>4 khách</option>

                        </select>

                    </div>

                    <button
                        class="btn btn-primary w-100">

                        Đặt phòng ngay

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<!-- Google Map -->

<section class="container pb-5">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h3>Vị trí Homestay</h3>

            <iframe
                src="https://maps.google.com/maps?q=10.8231,106.6297&z=15&output=embed"
                width="100%"
                height="400"
                style="border:0;"
                allowfullscreen>
            </iframe>

        </div>

    </div>

</section>

@endsection