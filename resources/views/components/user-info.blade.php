<li class="nav-item dropdown">
    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
        <i class="align-middle" data-feather="settings"></i>
    </a>

    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
        <img src="{{asset('img/avatars/avatar.jpg')}}" class="avatar img-fluid rounded me-1" alt="Admin" /> <span class="text-dark">Admin</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="{{url('/profile')}}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{url('/')}}"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{url('/')}}">Logout</a>
    </div>
</li>