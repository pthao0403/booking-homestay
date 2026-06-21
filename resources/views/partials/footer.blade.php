<footer class="bg-dark text-white mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h4 class="fw-bold text-primary">CloudStay</h4>
                <p class="text-light mb-0">
                    Nền tảng đặt homestay trực tuyến giúp tìm phòng, đặt phòng và theo dõi lịch lưu trú trong một luồng đơn giản.
                </p>
            </div>

            <div class="col-lg-2 col-md-4">
                <h5 class="fw-bold">Điều hướng</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('home') }}" class="text-decoration-none text-light">Trang chủ</a></li>
                    <li><a href="{{ route('rooms.index') }}" class="text-decoration-none text-light">Homestay</a></li>
                    @auth
                        <li><a href="{{ route('bookings.index') }}" class="text-decoration-none text-light">Booking của tôi</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="fw-bold">Hỗ trợ</h5>
                <ul class="list-unstyled mb-0">
                    <li>Email: support@cloudstay.com</li>
                    <li>Hotline: 1900 1234</li>
                    <li>Hỗ trợ 24/7</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="fw-bold">Liên kết nhanh</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('login') }}" class="text-decoration-none text-light">Đăng nhập</a>
                    @auth
                        <a href="{{ route('profile.index') }}" class="text-decoration-none text-light">Tài khoản</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-light">Dashboard admin</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="text-center">
            <small>&copy; {{ date('Y') }} CloudStay. Đã đăng ký mọi quyền.</small>
        </div>
    </div>
</footer>
