<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $menu_active == 'dashboard' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ $menu_active == 'user' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('master.user') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Pegawai</span></a>
    </li>

    <li class="nav-item {{ $menu_active == 'category' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('master.category') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Category</span></a>
    </li>

    <li class="nav-item {{ $menu_active == 'product' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('master.product') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Produk</span></a>
    </li>

    <li class="nav-item {{ $menu_active == 'location' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('master.location') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Lokasi</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Utilities Collapse Menu -->
    <div class="sidebar-heading">
        Manajemen Mutasi
    </div>

    <li class="nav-item {{ $menu_active == 'mutation' ? 'active' : '' }} ">
        <a class="nav-link" href="{{ route('mutation.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Mutasi</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ $menu_active == 'history' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('history.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan Mutasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->

</ul>


<script>

</script>