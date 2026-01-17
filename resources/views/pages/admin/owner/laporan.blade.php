@extends('layouts.main')

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-3">Laporan Transaksi</h4>

    {{-- FILTER --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="date" name="from" class="form-control"
                   value="{{ request('from') }}">
        </div>

        <div class="col-md-3">
            <input type="date" name="to" class="form-control"
                   value="{{ request('to') }}">
        </div>

        <div class="col-md-6">
            <button class="btn btn-primary">Filter</button>

            <a href="{{ route('owner.laporan.pdf', request()->query()) }}"
               class="btn btn-danger">
                Export PDF
            </a>
        </div>
    </form>

    {{-- TOTAL --}}
    <div class="alert alert-success">
        <strong>Total Pendapatan:</strong>
        Rp {{ number_format($total,0,',','.') }}
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->created_at->format('d M Y') }}</td>
                            <td>{{ $t->user->name ?? '-' }}</td>
                            <td>
                                Rp {{ number_format($t->total_harga,0,',','.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
