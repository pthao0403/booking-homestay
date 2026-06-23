<aside class="sidebar-admin">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Bảng điều khiển
            </a>
        </li>

        <li>
            <a href="{{ route('admin.rooms.index') }}" class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                Quản lý phòng
            </a>
        </li>

        <li>
            <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                Quản lý đặt phòng
            </a>
        </li>

        <li>
            <a href="{{ route('admin.google-vouchers') }}" class="sidebar-link {{ request()->routeIs('admin.google-vouchers') ? 'active' : '' }}">
                Quản lý mã ưu đãi
            </a>
        </li>

        <li>
            <a href="{{ route('profile.index') }}" class="sidebar-link">
                Thông tin cá nhân
            </a>
        </li>

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link logout">Đăng xuất</button>
            </form>
        </li>
    </ul>
</aside>
