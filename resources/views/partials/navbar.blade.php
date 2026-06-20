<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="/">
            CloudStay
        </a>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/rooms">
                        Phòng
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <span class="text-white me-2">Chào, <strong>{{ Auth::user()->name }}</strong></span>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-light btn-sm">Lịch sử đặt phòng</a>
                    
                    @if(Auth::user()->role === 'admin')
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