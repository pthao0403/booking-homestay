<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="/">
            CloudStay
        </a>

        <div class="ms-auto d-flex align-items-center gap-2 flex-wrap justify-content-end me-2">
            <a href="{{ route('login') }}"
               class="btn btn-light btn-sm">
                Đăng nhập
            </a>

            <a href="{{ route('register') }}"
               class="btn btn-warning btn-sm">
                Đăng ký
            </a>
        </div>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <div class="ms-auto d-flex align-items-center gap-2 flex-wrap justify-content-end">
                @auth
                    <span class="text-white me-2">
                        Chào, <strong>{{ Auth::user()->name }}</strong>
                    </span>

                    <a href="{{ route('dashboard') }}"
                       class="btn btn-outline-light btn-sm">
                        Tổng quan
                    </a>

                    <a href="{{ route('bookings.index') }}"
                       class="btn btn-outline-light btn-sm">
                        Lịch sử đặt phòng
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="btn btn-warning btn-sm">
                            Quản trị
                        </a>
                    @endif

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        <button type="submit"
                                class="btn btn-danger btn-sm">
                            Đăng xuất
                        </button>
                    </form>
                @endauth

                <div class="custom-translate ms-2" style="min-width: 170px;">
                    <div id="google_translate_element"></div>
                </div>
            </div>
        </div>
    </div>
</nav>
