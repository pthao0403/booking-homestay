@extends('layouts.app')

@section('title', 'Đăng nhập Admin - CloudStay')

@section('content')
<div class="auth-container" style="max-width: 450px; margin: 4rem auto;">
    <div class="auth-card" style="background: #f8fafc; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h2 class="text-center fw-bold mb-4" style="color: #0f172a;">Đăng Nhập Admin</h2>

        <form action="{{ route('admin.login.post') }}" method="POST" class="auth-form bg-white p-4 rounded-3 border">
            @csrf

            <div class="form-group mb-3 text-start">
                <label for="email" class="form-label fw-semibold text-secondary">Email</label>
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

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3" style="border-radius: 8px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">Đăng nhập Admin</button>

            <p class="auth-link text-center mt-2 mb-0 text-muted" style="font-size: 0.9rem;">
                Về trang đăng nhập người dùng: <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Đăng nhập</a>
            </p>
        </form>
    </div>
</div>
@endsection

