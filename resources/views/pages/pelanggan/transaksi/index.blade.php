@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
        <a href="{{ route('pelanggan.transaksi.create') }}"
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Transaksi
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Treatment</th>
                            <th>Berat</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($transaksis as $i => $transaksi)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            <td class="text-center">
                                <span class="badge badge-secondary">
                                    INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Pelanggan --}}
                            <td>
                                <strong>{{ $transaksi->user->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $transaksi->user->email ?? '' }}</small>
                            </td>

                            {{-- Layanan --}}
                            <td>
                                {{ $transaksi->layanan->nama_layanan ?? '-' }}
                            </td>

                            {{-- Treatment --}}
                            <td>
                                {{ $transaksi->treatment->nama_treatment ?? '-' }}
                            </td>

                            <td class="text-center">{{ $transaksi->berat }} kg</td>

                            <td class="text-right font-weight-bold">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- Metode Pembayaran --}}
                            <td class="text-center">
                                @if($transaksi->metode_pembayaran === 'midtrans')
                                    <span class="badge badge-dark">
                                        <i class="fas fa-qrcode"></i> QRIS
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ ucfirst($transaksi->metode_pembayaran) }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                {{ $transaksi->created_at->format('d M Y') }}
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($transaksi->payment_status === 'paid')
                                    <span class="badge badge-success">Lunas</span>
                                @else
                                    <span class="badge badge-danger">Belum Bayar</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                @if(
                                    $transaksi->metode_pembayaran === 'midtrans' &&
                                    $transaksi->payment_status !== 'paid'
                                )
                                    <a href="{{ route('pelanggan.transaksi.bayar', $transaksi->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Bayar
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
