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
            <li class="{{ request()->routeIs('dosen') ? 'active' : '' }}">
                <a href="{{ route('dosen') }}"><i data-feather="user"></i> <span>Dosen</span></a>
            </li>
            <li class="{{ request()->routeIs('kelas') ? 'active' : '' }}">
                <a href="{{ route('kelas') }}"><i data-feather="user"></i> <span>Kelas</span></a>
            </li>
        </ul>
    </div>
</div>

