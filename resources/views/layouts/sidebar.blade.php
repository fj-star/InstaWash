<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    @php
        $user = auth()->user();
        $role = $user->role;
    @endphp

    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="
        @if($role === 'admin') {{ route('admin.dashboard') }}
        @elseif($role === 'karyawan') {{ route('karyawan.dashboard') }}
        @elseif($role === 'owner') {{ route('owner.dashboard') }}
        @elseif($role === 'pelanggan') {{ route('pelanggan.dashboard') }}
        @else # @endif
       ">
        <div class="sidebar-brand-icon d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.jpg') }}"
                 alt="E-Laundry Logo"
                 style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
        </div>
        <div class="sidebar-brand-text mx-2 fw-bold lh-1">E-Laundry</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- --- IDENTITAS LOGIN DINAMIS (ID CARD) --- --}}
    <div class="sidebar-card d-flex flex-column align-items-center mt-3 mb-2 p-3 bg-primary border-0 mx-2 rounded shadow-sm">
        <div class="mb-2">
            {{-- Inisial Nama (Contoh: I untuk Ido/Iki) --}}
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold" 
                 style="width: 40px; height: 40px; border: 2px solid #fff;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>
        <div class="text-center">
            <p class="text-white small font-weight-bold mb-1">{{ $user->name }}</p>
            
            {{-- Warna Badge Jabatan Otomatis --}}
            @php
                $badgeColor = match($role) {
                    'owner'     => 'light',  
                    'admin'     => 'light',   
                    'karyawan'  => 'light',    
                    'pelanggan' => 'light',  
                    default     => 'light'
                };
            @endphp
            <span class="badge badge-{{ $badgeColor }} text-uppercase shadow-sm" style="font-size: 9px;">
                <i class="fas fa-user-tag mr-1"></i> {{ $role }}
            </span>
        </div>
    </div>

    <hr class="sidebar-divider">

    {{-- ================= MENU ROLE ================= --}}
    @if($role === 'admin')
        {{-- Menu Admin (Dashboard, Absensi, Laporan, dll) --}}
        <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.absensi.index') }}">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>Monitoring Absensi</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/layanans*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.layanans.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Layanan</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/pelanggans*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pelanggans.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/karyawan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Karyawan</span>
            </a>
        </li>

    @elseif($role === 'karyawan')
        {{-- Menu Karyawan --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('karyawan/absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('karyawan.absensi.index') }}">
                <i class="fas fa-fw fa-user-clock"></i>
                <span>Presensi Kerja</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.transaksi.index') }}">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
        </li>

    @elseif($role === 'owner')
        {{-- Menu Owner --}}
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

    @elseif($role === 'pelanggan')
        {{-- Menu Pelanggan --}}
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
    @endif

    <hr class="sidebar-divider">

    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start border-0">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>

</ul>