@extends('layouts.app')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')

    <div class="admin-content">
        <h2>Bảng điều khiển Admin</h2>

        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-primary">{{ $totalRooms }}</h3>
                        <p class="text-muted mb-0">Tổng số phòng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-success">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">Khách hàng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-warning">{{ $totalBookings }}</h3>
                        <p class="text-muted mb-0">Lượt đặt (Booking)</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-danger">{{ $revenue }}</h3>
                        <p class="text-muted mb-0">Doanh thu dự kiến</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-dark mb-2">Tổng số voucher</h5>
                        <p class="text-muted mb-0">{{ $totalVouchers }} mã voucher</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-info mb-2">Voucher đang hoạt động</h5>
                        <p class="text-muted mb-0">{{ $activeVouchers }} mã đang hoạt động</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-secondary mb-2">Voucher hết hạn</h5>
                        <p class="text-muted mb-0">{{ $expiredVouchers }} mã đã hết hạn</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
