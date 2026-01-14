@extends('layouts.main')

@section('title','Dashboard Karyawan')

@section('content')
<h4 class="mb-4">Dashboard Karyawan</h4>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Transaksi Hari Ini</h6>
                <h3>{{ $totalHariIni }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Pending</h6>
                <h3>{{ $pending }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Selesai</h6>
                <h3>{{ $selesai }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-primary">
         Transaksi
    </a>

    {{-- <a href="{{ route('karyawan.pelanggan.create') }}" class="btn btn-success"> --}}
        Pelanggan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        Transaksi Terbaru Hari Ini
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $t->status == 'selesai' ? 'success' : 'warning' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
