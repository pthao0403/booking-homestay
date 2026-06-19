<aside class="sidebar-admin">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.rooms.index') }}" class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                Manage Rooms
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                View Bookings
            </a>
        </li>
        
        <li>
            <a href="{{ route('profile.index') }}" class="sidebar-link">
                My Profile
            </a>
        </li>
        
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link logout">Logout</button>
            </form>
        </li>
    </ul>
</aside>
