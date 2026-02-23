<ul class="sidebar-nav">
    <li class="sidebar-header">
        Pages
    </li>

    <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ url('/admin/dashboard') }}">
            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Dashboard</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/category') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ url('/admin/category') }}">
            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Category</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/subcategory') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ url('/admin/subcategory') }}">
            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">Subcategory</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('admin/news') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ url('/admin/news') }}">
            <i class="align-middle" data-feather="chevron-right"></i> <span class="align-middle">News</span>
        </a>
    </li>
</ul>