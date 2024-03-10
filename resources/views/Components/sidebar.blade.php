<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="menu-title"><span>Main</span></li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                <a href="{{ route('user') }}"><i data-feather="user"></i> <span>Users</span></a>
            </li>
            <li class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                <a href="{{ route('welcome') }}"><i data-feather="user"></i> <span>Users</span></a>
            </li>
        </ul>
    </div>
</div>
