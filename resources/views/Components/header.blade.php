<div class="header header-one">
    <div class="header-left header-left-one">
        <a class="logo">
            <img src="{{ asset('assets/logoo.png') }}" alt="Logo">
        </a>
        <a>
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="assets/img/profiles/avatar-01.jpg" alt="">
                    <span class="status online"></span>
                </span>
                <span><b> @if(Auth::guard('mahasiswa')->check())
                    {{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}
                @elseif(Auth::guard('dosen')->check())
                    {{ Auth::guard('dosen')->user()->nama_dosen }}
                @elseif(Auth::check())
                    {{ Auth::user()->name }}
                @endif</b></span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('profile')}}"><i data-feather="user" class="me-1"></i>
                    Profile</a>
                {{-- <a class="dropdown-item" href="settings.html"><i data-feather="settings" class="me-1"></i>
                    Settings</a> --}}
                <a class="dropdown-item" href="{{route('logout')}}"><i data-feather="log-out" class="me-1"></i>
                    Logout</a>
            </div>
        </li>
    </ul>
</div>
