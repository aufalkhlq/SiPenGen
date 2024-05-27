<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-title"><span><b>Master Penjadwalan</b></span></li>

            <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                <a href="{{ route('user') }}"><i data-feather="users"></i> <span>Users</span></a>
            </li>
            <li class="{{ request()->routeIs('dosen') ? 'active' : '' }}">
                <a href="{{ route('dosen') }}"><i data-feather="user"></i> <span>Dosen</span></a>
            </li>
            <li class="{{ request()->routeIs('kelas') ? 'active' : '' }}">
                <a href="{{ route('kelas') }}"><i data-feather="user"></i> <span>Kelas</span></a>
            </li>
            <li class="{{ request()->routeIs('ruangan') ? 'active' : '' }}">
                <a href="{{ route('ruangan') }}"><i data-feather="user"></i> <span>Ruangan</span></a>
            </li>
            <li class="{{ request()->routeIs('matkul') ? 'active' : '' }}">
                <a href="{{ route('matkul') }}"><i data-feather="user"></i> <span>Mata Kuliah</span></a>
            </li>
            <li class="{{ request()->routeIs('hari', 'jam') ? 'active' : '' }}">
                <a href="#"><i data-feather="calendar"></i> <span> Waktu</span> <span class="menu-arrow"></span></a>
                <ul>
                    <li class="{{ request()->routeIs('hari') ? 'active' : '' }}"><a
                            href="{{ route('hari') }}">Hari</a></li>
                    <li class="{{ request()->routeIs('jam') ? 'active' : '' }}"><a
                            href="{{ route('jam') }}">Jam</a></li>
                </ul>
            </li>
            <li class="menu-title"><span><b>Master Enrollment</b></span></li>
            <li class="{{ request()->routeIs('pengampu') ? 'active' : '' }}">
                <a href="{{ route('pengampu') }}"><i data-feather="user"></i> <span>Pengampu</span></a>
            </li>
            {{-- jadwal --}}
            <li class="{{ request()->routeIs('jadwal') ? 'active' : '' }}">
                <a href="{{ route('jadwal') }}"><i data-feather="calendar"></i> <span>Jadwal</span></a>
            </li>
        </ul>
    </div>
</div>
