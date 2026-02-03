@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Karyawan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_karyawan'] }} Orang</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir Hari Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['hadir'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['terlambat'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Izin/Sakit/Cuti</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['izin'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5 text-center">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary py-3">
                    <h6 class="m-0 font-weight-bold text-white">QR Code Presensi</h6>
                </div>
                <div class="card-body">
                    <div class="p-3 border rounded bg-white shadow-sm mb-3">
                        {!! QrCode::size(250)->margin(2)->generate('ABSEN-INSTAWASH-' . date('Y-m-d')) !!}
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ date('l') }}</h5>
                    <p class="text-muted small">{{ date('d F Y') }}</p>
                    <button class="btn btn-sm btn-outline-primary btn-block" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak QR Tembok
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs card-header-tabs" id="absensiTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="hari-ini-tab" data-toggle="tab" href="#hari-ini" role="tab">Monitoring Hari Ini</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="rekap-tab" data-toggle="tab" href="#rekap" role="tab">Input Izin/Cuti</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="absensiTabContent">
                        <div class="tab-pane fade show active" id="hari-ini" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absensis as $a)
                                        <tr>
                                            <td><strong>{{ $a->user->name }}</strong></td>
                                            <td><span class="text-success font-weight-bold">{{ $a->jam_masuk ?? '--:--' }}</span></td>
                                            <td><span class="text-danger font-weight-bold">{{ $a->jam_keluar ?? '--:--' }}</span></td>
                                            <td>
                                                <span class="badge badge-{{ $a->status == 'hadir' ? 'success' : ($a->status == 'terlambat' ? 'warning' : 'info') }}">
                                                    {{ strtoupper($a->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.absensi.edit', $a->id) }}" class="btn btn-sm btn-warning btn-circle shadow-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $absensis->links() }}
                        </div>

                        <div class="tab-pane fade" id="rekap" role="tabpanel">
                            <form action="{{ route('admin.absensi.store_manual') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold">Karyawan</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach(\App\Models\User::where('role', 'karyawan')->get() as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="cuti">Cuti</option>
                                                <option value="alpha">Alpha (Tanpa Keterangan)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Keterangan (Alasan)</label>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Sakit Gigi">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                    <i class="fas fa-save mr-1"></i> Simpan Absensi Manual
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection