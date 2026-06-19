@extends('layouts.app')

@section('content')

<h2>Danh sách phòng</h2>

<div class="row">

@foreach($rooms as $room)

<div class="col-lg-4 mb-4">

    <div class="card h-100">

        <img src="{{ $room->thumbnail_url }}"
             class="card-img-top">

        <div class="card-body">

            <h5>{{ $room->name }}</h5>

            <p>{{ $room->address }}</p>

            <p>
                {{ number_format($room->price) }}
                VNĐ / đêm
            </p>

            <a href="/rooms/{{$room->id}}"
               class="btn btn-primary">
                Xem chi tiết
            </a>

        </div>

    </div>

</div>

@endforeach

</div>

@endsection