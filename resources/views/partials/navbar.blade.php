<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">CloudStay</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Chuyển đổi điều hướng">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">Homestay</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">Đơn đặt phòng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">Tài khoản</a>
                    </li>
                @endauth
            </ul>

            <div class="ms-auto d-flex align-items-center gap-2 flex-wrap">
                @auth
                    <span class="text-white-50 small">Xin chào, {{ Auth::user()->name }}</span>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">Quản trị</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
