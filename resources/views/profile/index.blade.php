@extends('layouts.app')

@section('title', 'Thông tin cá nhân - CloudStay')

@section('content')
<style>
    .profile-page-container {
        max-width: 900px;
        margin: 2rem auto;
    }
    .profile-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        position: relative;
    }
    .profile-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #6366f1, #10b981);
        border-radius: 2px;
    }
    .profile-card {
        border-radius: 16px;
        border: none;
    }
    .form-control-custom {
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .form-control-custom:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }
    .btn-update {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .btn-update:hover {
        background: linear-gradient(135deg, #4f46e5, #3730a3);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        color: white;
    }
</style>

<div class="profile-page-container container">
    <h2 class="profile-title">Thông Tin Tài Khoản</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Cột trái: Thông tin cá nhân -->
        <div class="col-md-6 mb-4">
            <div class="card profile-card shadow-sm p-4 bg-white border-0">
                <h4 class="fw-bold mb-4" style="color: #0f172a;"><i class="bi bi-person-fill text-primary me-2"></i>Thông tin cá nhân</h4>
                
                <form action="{{ route('profile.update') }}" method="POST" class="text-start">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Họ và Tên</label>
                        <input type="text" id="name" name="name" class="form-control form-control-custom" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Địa chỉ Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-custom" value="{{ auth()->user()->email }}" required>
                        @error('email')
                            <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="role" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Loại tài khoản</label>
                        <input type="text" id="role" class="form-control form-control-custom bg-light" value="{{ auth()->user()->role === 'admin' ? 'Quản trị viên (Admin)' : 'Khách hàng (Customer)' }}" readonly>
                    </div>
                    
                    <button type="submit" class="btn btn-update w-100 py-2.5">Cập nhật thông tin</button>
                </form>
            </div>
        </div>
        
        <!-- Cột phải: Đổi mật khẩu -->
        <div class="col-md-6 mb-4">
            <div class="card profile-card shadow-sm p-4 bg-white border-0">
                <h4 class="fw-bold mb-4" style="color: #0f172a;"><i class="bi bi-key-fill text-primary me-2"></i>Đổi mật khẩu</h4>
                
                @if(!auth()->user()->password)
                    <div class="alert alert-info text-start mb-4" style="border-radius: 10px; font-size: 0.9rem;">
                        <i class="bi bi-info-circle-fill me-2"></i>Tài khoản của bạn được đăng nhập bằng Google. Vui lòng thiết lập mật khẩu nếu muốn đăng nhập bằng email thường.
                    </div>
                @endif

                <form action="{{ route('profile.change-password') }}" method="POST" class="text-start">
                    @csrf
                    
                    @if(auth()->user()->password)
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Mật khẩu hiện tại</label>
                            <input type="password" id="current_password" name="current_password" class="form-control form-control-custom" required>
                            @error('current_password')
                                <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <!-- Ẩn trường mật khẩu cũ nếu là acc Google chưa tạo mật khẩu -->
                        <input type="hidden" name="current_password" value="google_oauth_no_password">
                    @endif
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Mật khẩu mới</label>
                        <input type="password" id="new_password" name="new_password" class="form-control form-control-custom" required placeholder="Tối thiểu 6 ký tự">
                        @error('new_password')
                            <span class="error text-danger" style="font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Xác nhận mật khẩu mới</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-custom" required>
                    </div>
                    
                    <button type="submit" class="btn btn-update w-100 py-2.5">Thay đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
