<aside class="sidebar-admin">
    <div class="sidebar-header">
        <h3>CloudStay Admin</h3>
    </div>

    <ul class="sidebar-menu mb-0">
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
                Quản lý booking
            </a>
        </li>
        <li>
            <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                Tài khoản
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
