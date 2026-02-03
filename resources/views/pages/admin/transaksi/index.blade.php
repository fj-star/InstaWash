@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi InstaWash</h1>
        <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Transaksi
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Total Harga</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Status Laundry</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $index => $transaksi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><small class="font-weight-bold">{{ $transaksi->order_id }}</small></td>
                            <td>{{ $transaksi->user?->name ?? 'User Terhapus' }}</td>
                            <td>{{ $transaksi->layanan?->nama_layanan }}</td>
                            <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td class="text-center"><span class="badge badge-dark">{{ strtoupper($transaksi->metode_pembayaran) }}</span></td>
                            <td class="text-center">
                                <span class="badge {{ $transaksi->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ strtoupper($transaksi->payment_status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $transaksi->status == 'pending' ? 'bg-warning' : ($transaksi->status == 'proses' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center">Data tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection