@extends('layouts.app')

@section('title', 'Mã ưu đãi - CloudStay')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Danh sách mã ưu đãi</h1>
        <p class="text-muted mb-0">Các voucher đang hoạt động được đồng bộ trực tiếp từ Google Sheets.</p>
    </div>

    <div class="row g-4">
        @forelse($vouchers as $voucher)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <span class="badge text-bg-success mb-3">Đang hoạt động</span>
                        <h3 class="h4 fw-bold mb-2">{{ $voucher['code'] }}</h3>
                        <p class="text-primary fw-semibold mb-3">{{ $voucher['label'] }}</p>
                        <p class="text-muted mb-0">Nhập mã này trong form đặt phòng để áp dụng khuyến mãi.</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center mb-0">
                    Hiện chưa có mã ưu đãi nào đang hoạt động.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
