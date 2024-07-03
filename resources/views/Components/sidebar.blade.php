
<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            @if(auth()->user()->role == 'admin')
            <li class="menu-title"><span><b>Master Penjadwalan</b></span></li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                <a href="{{ route('user') }}"><i data-feather="users"></i> <span>Users</span></a>
            </li>
            <li class="{{ request()->routeIs('dosen') ? 'active' : '' }}">
                <a href="{{ route('dosen') }}"><i data-feather="user"></i> <span>Dosen</span></a>
            </li>
            <li class="{{ request()->routeIs('kelas') ? 'active' : '' }}">
                <a href="{{ route('kelas') }}"><i data-feather="home"></i> <span>Kelas</span></a>
            </li>
            <li class="{{ request()->routeIs('ruangan') ? 'active' : '' }}">
                <a href="{{ route('ruangan') }}"><i data-feather="home"></i> <span>Ruangan</span></a>
            </li>
            <li class="{{ request()->routeIs('matkul') ? 'active' : '' }}">
                <a href="{{ route('matkul') }}"><i data-feather="user"></i> <span>Mata Kuliah</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i data-feather="calendar"></i> <span>Waktu</span><span class="menu-arrow"></span></a>
                <ul>
                    <li><a href="{{ route('hari') }}" class="{{ request()->routeIs('hari') ? 'active' : '' }}">Hari</a></li>
                    <li><a href="{{ route('jam') }}" class="{{ request()->routeIs('jam') ? 'active' : '' }}">Jam</a></li>
                </ul>
            </li>

            <li class="menu-title"><span><b>Master Enrollment</b></span></li>
            <li class="{{ request()->routeIs('pengampu') ? 'active' : '' }}">
                <a href="{{ route('pengampu') }}"><i data-feather="user"></i> <span>Pengampu</span></a>
            </li>
            <li class="{{ request()->routeIs('jadwal') ? 'active' : '' }}">
                <a href="{{ route('jadwal') }}"><i data-feather="calendar"></i> <span>Jadwal</span></a>
            </li>
            @endif
            @if(auth()->user()->role == 'mahasiswa')
            <li class="menu-title"><span><b>Master Penjadwalan</b></span></li>
            <li class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <a href="{{ route('mahasiswa.dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('mahasiswa.jadwal') ? 'active' : '' }}">
                <a href="{{ route('mahasiswa.jadwal') }}"><i data-feather="home"></i> <span>Jadwal</span></a>
            </li>

            @endif
        </ul>
    </div>
</div>


