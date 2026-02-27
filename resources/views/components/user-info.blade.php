<li class="nav-item dropdown">
    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
        <i class="align-middle" data-feather="settings"></i>
    </a>

    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
        <img src="{{asset('img/avatars/avatar.jpg')}}" class="avatar img-fluid rounded me-1" alt="" /> <span class="text-dark">@role('admin'){{'Admin'}}@endrole
            @role('user'){{'User'}}@endrole
            @role('editor'){{'Editor'}}@endrole</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="{{url('/admin/profile')}}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
        <a class="dropdown-item" href="{{url('/admin/change-password')}}"><i class="align-middle me-1" data-feather="lock"></i> Change Password</a>
        <a class="dropdown-item" href="{{url('/admin/logout')}}"><i class="align-middle me-1" data-feather="log-out"></i> Logout</a>
    </div>
</li>