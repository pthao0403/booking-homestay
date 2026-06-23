@extends('layouts.app')

@section('title', 'Mã ưu đãi - CloudStay')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Danh sách mã ưu đãi</h1>
        <p class="text-muted mb-0">Khám phá các mã giảm giá độc quyền giúp tiết kiệm chi phí khi đặt homestay.</p>
    </div>

    <div class="row g-4">
        @forelse($vouchers as $voucher)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <span class="badge text-bg-success mb-3">Đang hoạt động</span>
                        <h3 class="h4 fw-bold mb-2">{{ $voucher['code'] }}</h3>
                        <p class="text-primary fw-semibold mb-3">{{ $voucher['label'] }}</p>
                        <p class="text-muted mb-3">Nhập mã này trong form đặt phòng để áp dụng khuyến mãi.</p>
                        <a href="{{ route('rooms.index') }}" class="text-decoration-none fw-semibold" style="color: #4f46e5;">
                            Dùng ngay <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 px-4" style="border-radius: 24px; background: #fff; border: 1px dashed #cbd5e1;">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; border-radius: 22px; background: rgba(148, 163, 184, 0.12); color: #64748b;">
                        <i class="bi bi-ticket-perforated" style="font-size: 1.8rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #0f172a;">Chưa có voucher hoạt động</h4>
                    <p class="text-muted mb-0">Hiện chưa có mã ưu đãi nào đang hoạt động. Vui lòng quay lại sau để cập nhật khuyến mãi mới.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
