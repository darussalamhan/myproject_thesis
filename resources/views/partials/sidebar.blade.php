<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
        <div class="sidebar-brand-text mx-6">Sistem Seleksi Calon Penerima PKH</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Menu') }}
    </div>

    <!-- Nav Item - User -->
    <li class="nav-item {{ Nav::isRoute('user') }}">
        <a class="nav-link" href="{{ route('user') }}">
            <i class="fa-solid fa-user-pen"></i>
            <span>{{ __('Kelola User') }}</span>
        </a>
    </li>

    <!-- Nav Item - Kriteria -->
    <li class="nav-item {{ Nav::isRoute('kriteria') }}">
        <a class="nav-link" href="{{ route('kriteria.index') }}">
            <i class="fa-solid fa-cube"></i>
            <span>{{ __('Kelola Kriteria') }}</span>
        </a>
    </li>

    <!-- Nav Item - Data Pemohon -->
    <li class="nav-item {{ Nav::isRoute('pemohon') }}">
        <a class="nav-link" href="{{ route('pemohon.index') }}">
            <i class="fa-solid fa-people-roof"></i>
            <span>{{ __('Kelola Data Pemohon') }}</span>
        </a>
    </li>

    <!-- Nav Item - Penilaian -->
    <li class="nav-item {{ Nav::isRoute('penilaian') }}">
        <a class="nav-link" href="{{ route('penilaian') }}">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>{{ __('Penilaian') }}</span>
        </a>
    </li>

    <!-- Nav Item - Hasil Perhitungan -->
    <li class="nav-item {{ Nav::isRoute('hasil') }}">
        <a class="nav-link" href="{{ route('hasil') }}">
            <i class="fa-solid fa-calculator"></i>
            <span>{{ __('Hasil Perhitungan') }}</span>
        </a>
    </li>

    <!-- Nav Item - Laporan Hasil Akhir -->
    <li class="nav-item {{ Nav::isRoute('laporan') }}">
        <a class="nav-link" href="{{ route('laporan') }}">
            <i class="fa-solid fa-chart-area"></i>
            <span>{{ __('Laporan') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Logout -->
    <li class="nav-item {{ Nav::isRoute('logout') }}">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>{{ __('Logout') }}</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>