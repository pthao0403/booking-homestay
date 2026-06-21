@extends('layouts.app')

@section('title','Admin Dashboard')

@section('content')

<div class="container py-5">

    <h2 class="mb-4">
        Dashboard Admin
    </h2>

    <div class="row">

        <div class="col-md-3 mb-3">

            <div class="card text-center shadow-sm">

                <div class="card-body">

                    <h2>20</h2>

                    <p>Tổng phòng</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card text-center shadow-sm">

                <div class="card-body">

                    <h2>80</h2>

                    <p>Khách hàng</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card text-center shadow-sm">

                <div class="card-body">

                    <h2>150</h2>

                    <p>Booking</p>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card text-center shadow-sm">

                <div class="card-body">

                    <h2>
                        250M
                    </h2>

                    <p>
                        Doanh thu
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h4>Quản lý phòng</h4>

                    <a href="/rooms"
                       class="btn btn-primary">

                        Xem danh sách phòng

                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h4>Quản lý Booking</h4>

                    <a href="/bookings"
                       class="btn btn-success">

                        Xem danh sách booking

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection