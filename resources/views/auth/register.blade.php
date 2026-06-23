@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - CloudStay')

@section('content')
<div class="auth-container" style="max-width: 500px; margin: 3rem auto;">
    <div class="auth-card" style="background: #f8fafc; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h2 class="text-center fw-bold mb-4" style="color: #0f172a;">Đăng Ký Tài Khoản</h2>
        
        <form action="{{ route('register') }}" method="POST" class="auth-form bg-white p-4 rounded-3 border">
            @csrf
            
            <div class="form-group mb-3 text-start">
                <label for="name" class="form-label fw-semibold text-secondary">Họ và Tên</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}" style="border-radius: 8px; padding: 0.75rem;" placeholder="Nhập đầy đủ họ và tên">
                @error('name')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-3 text-start">
                <label for="email" class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" style="border-radius: 8px; padding: 0.75rem;" placeholder="example@email.com">
                @error('email')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-3 text-start">
                <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required style="border-radius: 8px; padding: 0.75rem;" placeholder="Tối thiểu 6 ký tự">
                @error('password')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-4 text-start">
                <label for="password_confirmation" class="form-label fw-semibold text-secondary">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required style="border-radius: 8px; padding: 0.75rem;" placeholder="Nhập lại mật khẩu">
                @error('password_confirmation')
                    <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>
            

        <div class="mt-4 flex justify-center">
            <div class="g-recaptcha" data-sitekey="6LeYGy4tAAAAAEZ5RbWMHeG1akKzenTZEcwD4bDA"></div>
        </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" style="border-radius: 8px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">Đăng ký</button>
        </form>
        
        <p class="auth-link text-center mt-4 mb-0 text-muted" style="font-size: 0.9rem;">Đã có tài khoản? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Đăng nhập tại đây</a></p>
    </div>
</div>
@endsection
