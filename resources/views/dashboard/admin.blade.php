@extends('layouts.app')

@section('title', 'Dashboard quản trị - CloudStay')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-xl-3">
            @include('partials.sidebar-admin')
        </div>

        <div class="col-xl-9">
            <div class="admin-hero-panel mb-4">
                <div>
                    <span class="section-kicker">Khu vực quản trị</span>
                    <h1 class="h2 fw-bold mb-2">Bảng điều khiển CloudStay</h1>
                    <p class="text-muted mb-0">
                        Theo dõi nhanh tình hình phòng, người dùng, booking và doanh thu xác nhận trong một giao diện thống nhất.
                    </p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary">Quản lý phòng</a>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">Quản lý booking</a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6 col-xxl-3">
                    <div class="admin-stat-card">
                        <span class="admin-stat-label">Tổng số phòng</span>
                        <strong class="admin-stat-value">{{ $totalRooms }}</strong>
                        <span class="admin-stat-note">Đang quản lý trong hệ thống</span>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="admin-stat-card">
                        <span class="admin-stat-label">Khách hàng</span>
                        <strong class="admin-stat-value">{{ $totalUsers }}</strong>
                        <span class="admin-stat-note">Tài khoản đang hoạt động</span>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="admin-stat-card">
                        <span class="admin-stat-label">Tổng booking</span>
                        <strong class="admin-stat-value">{{ $totalBookings }}</strong>
                        <span class="admin-stat-note">Bao gồm chờ duyệt và đã xác nhận</span>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="admin-stat-card admin-stat-card-highlight">
                        <span class="admin-stat-label">Doanh thu xác nhận</span>
                        <strong class="admin-stat-value">{{ number_format((float) $totalRevenue) }} VNĐ</strong>
                        <span class="admin-stat-note">Tính từ các booking đã xác nhận</span>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="admin-feature-card h-100">
                        <div class="admin-feature-icon"><i class="bi bi-house-door"></i></div>
                        <h2 class="h5 fw-bold">Quản lý phòng</h2>
                        <p class="text-muted">
                            Thêm mới homestay, cập nhật thông tin chi tiết, ảnh đại diện và nội dung mô tả hiển thị trên website.
                        </p>
                        <div class="d-flex gap-2 flex-wrap mt-auto">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary">Xem danh sách phòng</a>
                            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Thêm phòng mới</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="admin-feature-card h-100">
                        <div class="admin-feature-icon"><i class="bi bi-journal-check"></i></div>
                        <h2 class="h5 fw-bold">Quản lý booking</h2>
                        <p class="text-muted">
                            Theo dõi yêu cầu đặt phòng mới, lọc theo trạng thái và xác nhận hoặc từ chối ngay trong bảng quản trị.
                        </p>
                        <div class="d-flex gap-2 flex-wrap mt-auto">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-success">Mở trang booking</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
