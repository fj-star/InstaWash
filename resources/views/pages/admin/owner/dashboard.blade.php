@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Owner</h3>
        <p class="text-muted mb-0">
            Ringkasan pendapatan & aktivitas terbaru
            <span class="ms-2">({{ now()->format('F Y') }})</span>
        </p>
    </div>

    {{-- STAT CARD --}}
    <div class="row mb-4">

        {{-- TOTAL TRANSAKSI --}}
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Transaksi</h6>
                    <h3 class="fw-bold mb-0">
                        {{ $total_transaksi ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- TOTAL PENDAPATAN --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Pendapatan</h6>
                    <h3 class="fw-bold text-success mb-0">
                        Rp {{ number_format($total_pendapatan ?? 0,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- GRAFIK PENDAPATAN --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Grafik Pendapatan {{ now()->year }}</h5>
        </div>
        <div class="card-body">
            <canvas id="pendapatanChart" style="height:300px" ></canvas>
        </div>
    </div>

    {{-- TRANSAKSI TERAKHIR --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Transaksi Terakhir</h5>
            <small class="text-muted">
                Menampilkan {{ $transaksis->count() ?? 0 }} data terakhir
            </small>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksis as $t)

                        @php
                            $statusColor = match($t->status) {
                                'pending' => 'warning',
                                'proses'  => 'info',
                                'selesai' => 'success',
                                default   => 'secondary',
                            };
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->user->name ?? '-' }}</td>
                            <td>
                                Rp {{ number_format($t->total_harga ?? 0,0,',','.') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($t->status ?? '-') }}
                                </span>
                            </td>
                            <td>
                                {{ optional($t->created_at)->format('d M Y') }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

{{-- SCRIPT --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawData = @json($chartData ?? []);

    // inisialisasi 12 bulan (biar ga bolong)
    const labels = [
        'Jan','Feb','Mar','Apr','Mei','Jun',
        'Jul','Agu','Sep','Okt','Nov','Des'
    ];

    const values = Array(12).fill(0);

    rawData.forEach(item => {
        values[item.bulan - 1] = item.total;
    });

    const ctx = document.getElementById('pendapatanChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: values,
                    backgroundColor: '#198754',
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value =>
                                'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
