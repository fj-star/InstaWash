@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi Saya</h1>
        <a href="{{ route('pelanggan.transaksi.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Cucian
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-left-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pesanan</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Layanan & Treatment</th>
                            <th>Berat</th>
                            <th>Total Harga</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Status Laundry</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($transaksis as $i => $transaksi)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="text-center">
                                <span class="badge badge-secondary p-2">
                                    INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $transaksi->layanan->nama_layanan ?? '-' }}</strong><br>
                                <small class="text-primary">{{ $transaksi->treatment->nama_treatment ?? '-' }}</small>
                            </td>
                            <td class="text-center">{{ $transaksi->berat }} kg</td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-center text-uppercase small font-weight-bold">
                                {{ $transaksi->metode_pembayaran }}
                            </td>

                            {{-- KOLOM STATUS BAYAR --}}
                            <td class="text-center">
                                @if($transaksi->payment_status === 'paid')
                                    <span class="badge badge-success shadow-sm">
                                        <i class="fas fa-check-circle"></i> LUNAS
                                    </span>
                                @elseif($transaksi->payment_status === 'pending')
                                    <span class="badge badge-warning shadow-sm">MENUNGGU</span>
                                @else
                                    <span class="badge badge-danger shadow-sm">BELUM BAYAR</span>
                                @endif
                            </td>

                            {{-- KOLOM STATUS LAUNDRY --}}
                            <td class="text-center text-uppercase font-weight-bold small">
                                @php
                                    $statusColor = [
                                        'pending' => 'text-muted',
                                        'proses'  => 'text-primary',
                                        'selesai' => 'text-success'
                                    ];
                                @endphp
                                <span class="{{ $statusColor[$transaksi->status] ?? 'text-dark' }}">
                                    {{ $transaksi->status }}
                                </span>
                            </td>

                            {{-- KOLOM AKSI --}}
                            <td class="text-center">
    @if($transaksi->payment_status === 'paid')
        {{-- Kalau sudah lunas, tombol Bayar HILANG, ganti teks --}}
        <span class="text-success font-weight-bold">
            <i class="fas fa-check-double"></i> SUDAH LUNAS
        </span>
    @elseif($transaksi->metode_pembayaran === 'midtrans')
        {{-- Kalau belum lunas & pake Midtrans, baru muncul tombol --}}
        <a href="{{ route('pelanggan.transaksi.bayar', $transaksi->id) }}"
           class="btn btn-sm btn-primary">
            Bayar
        </a>
    @else
        <span class="text-muted small italic">Bayar di Kasir</span>
    @endif
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-3x mb-3"></i><br>
                                Belum ada riwayat transaksi.
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