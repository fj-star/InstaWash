@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-3 text-gray-800">Laporan Transaksi</h4>

    {{-- Form Filter --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('owner.laporan.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold text-muted">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-muted">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    <a href="{{ route('owner.laporan.pdf', ['from' => $from, 'to' => $to]) }}" class="btn btn-danger">Export PDF</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="alert alert-success shadow-sm border-0">
        <span class="font-weight-bold">Total Pendapatan:</span>
        <h4 class="mb-0 font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</h4>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Status Laundry</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="font-weight-bold text-primary">
                                    {{ $t->pelanggan->name ?? $t->user->name ?? '-' }}
                                </span><br>
                                <small class="text-muted">{{ $t->order_id }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $t->status == 'selesai' ? 'success' : 'info' }}">
                                    {{ strtoupper($t->status) }}
                                </span>
                            </td>
                            <td class="text-end font-weight-bold">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted italic">Tidak ada transaksi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection