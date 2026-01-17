<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- BRAND -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="#">

        <div class="sidebar-brand-icon d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.jpg') }}"
                 alt="E-Laundry Logo"
                 style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
        </div>

        <div class="sidebar-brand-text mx-2 fw-bold lh-1">
            E-Laundry
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- ================= ADMIN ================= --}}
    @if(auth()->user()->role === 'admin')

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.layanans.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Layanan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.pelanggans.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>

    {{-- ================= KARYAWAN ================= --}}
    @elseif(auth()->user()->role === 'karyawan')

        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.transaksi.index') }}">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.pelanggan.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>

    {{-- ================= OWNER ================= --}}
    @elseif(auth()->user()->role === 'owner')

        <li class="nav-item">
            <a class="nav-link" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('owner.laporan.index') }}">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Laporan</span>
            </a>
        </li>

    {{-- ================= PELANGGAN ================= --}}
    @elseif(auth()->user()->role === 'pelanggan')

        <li class="nav-item">
            <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('pelanggan.transaksi.index') }}">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil Saya</span>
            </a>
        </li>

    @endif

    <hr class="sidebar-divider">

    <!-- LOGOUT -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>

</ul>
<!-- End of Sidebar -->
