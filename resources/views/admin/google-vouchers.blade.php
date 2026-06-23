@extends('layouts.app')

@section('title', 'Quản lý mã ưu đãi - Admin')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')

    <div class="admin-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-2">Quản lý mã ưu đãi</h2>
            <p class="text-muted mb-0">Đây là phần tích hợp Google Sheets của hệ thống CloudStay.</p>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(16, 185, 129, 0.08));">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(99, 102, 241, 0.14); color: #4f46e5;">Google Sheets Integration</span>
                        <h3 class="fw-bold mb-2" style="color: #0f172a;">Quản lý voucher trực tiếp từ Google Sheets</h3>
                        <p class="text-muted mb-0" style="max-width: 720px;">
                            Admin có thể xem dữ liệu mã giảm giá hiện tại ngay trong hệ thống và mở trực tiếp Google Sheets để cập nhật mã, mức giảm và trạng thái hoạt động.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ $manageSheetUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg px-4" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; border-radius: 14px;">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Mở Google Sheets
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Tổng số voucher</p>
                        <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ count($vouchers) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Đang hoạt động</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $activeCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <p class="text-muted mb-2">Hết hạn</p>
                        <h3 class="fw-bold mb-0 text-secondary">{{ $expiredCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">Dữ liệu mã giảm giá</h4>
                        <p class="text-muted mb-0">Danh sách đang đồng bộ từ Google Sheets.</p>
                    </div>
                    <a href="{{ $publicSheetUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary">
                        <i class="bi bi-eye me-2"></i>Xem bản công khai
                    </a>
                </div>

                @if(count($vouchers) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã voucher</th>
                                    <th>Loại giảm giá</th>
                                    <th>Mức giảm</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td class="fw-semibold">{{ $voucher['code'] }}</td>
                                        <td>{{ $voucher['type'] === 'percent' ? 'Phần trăm' : 'Tiền cố định' }}</td>
                                        <td class="text-primary fw-semibold">{{ $voucher['label'] }}</td>
                                        <td>
                                            @if($voucher['status'] === 'active')
                                                <span class="badge text-bg-success">Đang hoạt động</span>
                                            @elseif($voucher['status'] === 'expired')
                                                <span class="badge text-bg-secondary">Hết hạn</span>
                                            @else
                                                <span class="badge text-bg-light">{{ ucfirst($voucher['status']) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; border-radius: 20px; background: rgba(148, 163, 184, 0.12); color: #64748b;">
                            <i class="bi bi-ticket-perforated" style="font-size: 1.8rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Chưa có voucher để hiển thị</h5>
                        <p class="text-muted mb-0">Hãy kiểm tra lại Google Sheets hoặc thêm mã ưu đãi mới để đồng bộ vào hệ thống.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
