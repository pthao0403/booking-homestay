@extends('layouts.app')

@section('title', 'Đăng nhập - CloudStay')

@section('content')
<div class="auth-container" style="max-width: 450px; margin: 4rem auto;">
    <div class="auth-card" style="background: #f8fafc; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h2 class="text-center fw-bold mb-4" style="color: #0f172a;">Đăng Nhập</h2>
        
        <form action="{{ route('login') }}" method="POST" class="auth-form bg-white p-4 rounded-3 border">
            @csrf
            
            <div class="form-group mb-3 text-start">
                <label for="email" class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" style="border-radius: 8px; padding: 0.75rem;">
                @error('email')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-3 text-start">
                <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required style="border-radius: 8px; padding: 0.75rem;">
                @error('password')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group checkbox mb-4 d-flex align-items-center gap-2">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label text-muted" style="font-size: 0.9rem;">Ghi nhớ đăng nhập</label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3" style="border-radius: 8px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">Đăng nhập</button>

            <a href="{{ route('admin.login') }}" class="btn btn-outline-dark w-100 py-2 fw-semibold d-flex align-items-center justify-content-center" style="border-radius: 8px; border-color: #111827; color: #111827; background: white; transition: all 0.3s;">
                <i class="bi bi-shield-lock me-2"></i> Đăng nhập Admin
            </a>
            
            <div class="position-relative text-center my-4">
                <hr class="text-muted">
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted" style="font-size: 0.85rem;">HOẶC</span>
            </div>
            
            <a href="{{ route('auth.google') }}" class="btn btn-outline-danger w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; border-color: #ef4444; color: #ef4444; background: white; transition: all 0.3s;">
                <i class="bi bi-google"></i> Đăng nhập bằng Google
            </a>
        </form>
        
        <p class="auth-link text-center mt-4 mb-0 text-muted" style="font-size: 0.9rem;">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Đăng ký tại đây</a></p>
    </div>
</div>
@endsection
