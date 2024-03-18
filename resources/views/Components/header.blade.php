<div class="header header-one">
    <div class="header-left header-left-one">
        {{-- <a href="index.html" class="logo">
            <img src="assets/img/logo.png" alt="Logo">
        </a>
        <a href="index.html" class="white-logo">
            <img src="assets/img/logo-white.png" alt="Logo">
        </a>
        <a href="index.html" class="logo logo-small">
            <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
        </a> --}}
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
    <div class="top-nav-search">
        <form>
            <input type="text" class="form-control" placeholder="Search here">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
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
                <span>Admin</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="profile.html"><i data-feather="user" class="me-1"></i>
                    Profile</a>
                <a class="dropdown-item" href="settings.html"><i data-feather="settings" class="me-1"></i>
                    Settings</a>
                <a class="dropdown-item" href="{{route('logout')}}"><i data-feather="log-out" class="me-1"></i>
                    Logout</a>
            </div>
        </li>
    </ul>
</div>
