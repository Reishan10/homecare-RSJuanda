<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets') }}/images/juanda_header.png" alt="" height="35">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets') }}/images/favicon_juanda.png" alt="" height="35">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="fa-solid fa-comment"></i>
                    <span> Chat </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->segment(1) == 'dokter' ? 'active' : '' }}">
                <a href="{{ route('dokter.index') }}" class="side-nav-link">
                    <i class="fa-solid fa-user-doctor"></i>
                    <span> Dokter </span>
                </a>
            </li>
            <li class="side-nav-item {{ request()->segment(1) == 'perawat' ? 'active' : '' }}">
                <a href="{{ route('perawat.index') }}" class="side-nav-link">
                    <i class="fa-sharp fa-solid fa-user-nurse"></i>
                    <span> Perawat </span>
                </a>
            </li>
            <li class="side-nav-item {{ request()->segment(1) == 'pasien' ? 'active' : '' }}">
                <a href="{{ route('pasien.index') }}" class="side-nav-link">
                    <i class="fa-solid fa-notes-medical"></i>
                    <span> Pasien </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}" class="side-nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span> Keluar </span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
