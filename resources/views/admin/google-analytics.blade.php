@extends('layouts.app')

@section('title', 'Tích hợp Google Analytics - Admin')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')

    <div class="admin-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-2">Tích hợp Google Analytics</h2>
            <p class="text-muted mb-0">Đây là phần tích hợp Google Analytics của hệ thống CloudStay.</p>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(249, 115, 22, 0.08));">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(59, 130, 246, 0.14); color: #2563eb;">Google Analytics Integration</span>
                        <h3 class="fw-bold mb-2" style="color: #0f172a;">Theo dõi dữ liệu truy cập trực tiếp từ Google Analytics</h3>
                        <p class="text-muted mb-0" style="max-width: 720px;">
                            Admin có thể mở nhanh trang Google Analytics để theo dõi lượt truy cập realtime, hành vi người dùng và hiệu quả hoạt động của website CloudStay.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ $manageUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg px-4" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; border-radius: 14px;">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Mở Google Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Trạng thái</p>
                        <h4 class="fw-bold mb-0 text-success">Đã kết nối</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Lượt truy cập hôm nay</p>
                        <h4 class="fw-bold mb-0" style="color: #0f172a;">125</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Người dùng đang hoạt động</p>
                        <h4 class="fw-bold mb-0" style="color: #0f172a;">8</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Tổng lượt xem trang</p>
                        <h4 class="fw-bold mb-3" style="color: #0f172a;">560</h4>
                        @if($manageUrl)
                            <a href="{{ $manageUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                                <i class="bi bi-box-arrow-up-right me-2"></i>Mở Google Analytics
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Measurement ID</p>
                        <h4 class="fw-bold mb-0" style="color: #0f172a;">{{ $measurementId ?: 'Chưa cấu hình' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
