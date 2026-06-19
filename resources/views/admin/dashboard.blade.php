@extends('layouts.app')

@section('content')

<h2>Dashboard</h2>

<div class="row">

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h3>
                    {{$totalRooms}}
                </h3>

                <p>Tổng phòng</p>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h3>
                    {{$totalUsers}}
                </h3>

                <p>Khách hàng</p>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h3>
                    {{$totalBookings}}
                </h3>

                <p>Booking</p>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h3>
                    {{$revenue}}
                </h3>

                <p>Doanh thu</p>

            </div>

        </div>

    </div>

</div>

@endsection