@extends('layouts.app')

@section('title', 'Đăng nhập Google Giả lập - CloudStay')

@section('content')
<div class="auth-container" style="max-width: 450px; margin: 4rem auto;">
    <div class="auth-card" style="background: #fff8f8; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.08); border: 1px solid #fee2e2;">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-3" style="width: 60px; height: 60px; font-size: 1.8rem;">
                <i class="bi bi-google"></i>
            </div>
            <h2 class="fw-bold mb-1" style="color: #991b1b;">Google Mock Login</h2>
            <p class="text-muted" style="font-size: 0.9rem;">Hệ thống phát hiện bạn chưa cấu hình Google OAuth trong `.env`. Chế độ giả lập được bật để phục vụ việc kiểm thử nhanh chóng.</p>
        </div>
        
        <form action="{{ route('auth.google.mock.post') }}" method="POST" class="auth-form bg-white p-4 rounded-3 border">
            @csrf
            
            <div class="form-group mb-3 text-start">
                <label for="name" class="form-label fw-semibold text-secondary">Họ tên hiển thị (Mock)</label>
                <input type="text" id="name" name="name" class="form-control" required value="Google Test User" style="border-radius: 8px; padding: 0.75rem;">
            </div>
            
            <div class="form-group mb-4 text-start">
                <label for="email" class="form-label fw-semibold text-secondary">Email Google (Mock)</label>
                <input type="email" id="email" name="email" class="form-control" required value="googletest@example.com" style="border-radius: 8px; padding: 0.75rem;">
                <span class="text-muted d-block mt-1" style="font-size: 0.8rem;">*Nhập email có chứa chữ "admin" (ví dụ: admin@example.com) nếu muốn đăng nhập bằng tài khoản Admin.</span>
            </div>
            
            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold" style="border-radius: 8px; background-color: #db4437; border: none; transition: all 0.3s;">
                <i class="bi bi-shield-check me-2"></i> Xác nhận Đăng nhập (Mock)
            </button>
        </form>
        
        <a href="{{ route('login') }}" class="btn btn-link w-100 mt-3 text-decoration-none text-muted" style="font-size: 0.9rem;">Quay lại trang Đăng nhập thường</a>
    </div>
</div>
@endsection
