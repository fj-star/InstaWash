<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" 
       href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('pelanggan.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="E-Laundry Logo" style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">E-Laundry</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Sidebar untuk ADMIN --}}
    @if(auth()->user()->role == 'admin')
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

    {{-- Sidebar untuk PELANGGAN --}}
    @elseif(auth()->user()->role == 'pelanggan')
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

    @if(auth()->user()->role === 'karyawan')
<li class="nav-item">
    <a href="{{ route('karyawan.dashboard') }}" class="nav-link">
        Dashboard
    </a>
</li>
@endif

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <form method="POST" id="btn-logout" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
</ul>
<!-- End of Sidebar -->
