@extends('layouts.app')

@section('title', 'Thông tin tài khoản - CloudStay')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h1 class="h4 fw-bold mb-4">Thông tin tài khoản</h1>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Vai trò</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->role === 'admin' ? 'Admin' : 'Khách hàng' }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-4">Đổi mật khẩu</h2>

                    @if(!auth()->user()->password)
                        <div class="alert alert-info">
                            Tài khoản này đang đăng nhập bằng Google. Bạn vẫn có thể thiết lập mật khẩu mới tại đây.
                        </div>
                    @endif

                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf

                        @if(auth()->user()->password)
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                            </div>
                        @else
                            <input type="hidden" name="current_password" value="google_oauth_no_password">
                        @endif

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100">Lưu mật khẩu mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
