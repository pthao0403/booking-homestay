@extends('layouts.app')

@section('content')

<div class="p-5 bg-light rounded">

    <h1>CloudStay</h1>

    <p>
        Hệ thống đặt Homestay trên nền tảng Cloud.
    </p>

</div>

<div class="row mt-4">

    @foreach($rooms as $room)

    <div class="col-md-4 mb-4">

        <div class="card">

            <img src="{{ $room->thumbnail_url }}"
                 class="card-img-top">

            <div class="card-body">

                <h5>
                    {{ $room->name }}
                </h5>

                <p>
                    {{ number_format($room->price) }} VNĐ
                </p>

                <a href="/rooms/{{$room->id}}"
                   class="btn btn-primary">
                    Chi tiết
                </a>

            </div>

        </div>

    </div>

    @endforeach

</div>

@endsection