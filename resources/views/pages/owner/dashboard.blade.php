@extends('layouts.main')

@section('content')
<div class="container-fluid">
    {{-- HEADER GAGAH --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Executive Overview</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    {{-- ROW 1: STATS CARDS DENGAN ICON GLOW --}}
    <div class="row">
        {{-- Omset Card --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 bg-gradient-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($omset_bulan_ini,0,',','.') }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> High Performance</span>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-money-bill-wave fa-2x text-primary"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pesanan Aktif dengan Animasi Pulse (via CSS) --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pesanan_proses }} Unit</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-spinner fa-spin fa-2x text-info"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ... tambahkan card lain dengan style serupa ... --}}
    </div>

    {{-- ROW 2: DUA GRAFIK BERSANDING --}}
    <div class="row">
        {{-- Area Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Growth</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Donut Chart --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Composition</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 260px;">
                        <canvas id="orderPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-primary"></i> Selesai</span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Proses</span>
                        <span class="mr-2"><i class="fas fa-circle text-warning"></i> Pending</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. AMBIL DATA DENGAN CARA PALING AMAN ---
    const rawChartData = {{ \Illuminate\Support\Js::from($chartData) }};
    const rawStatusData = {{ \Illuminate\Support\Js::from($statusData) }};

    // --- 2. LOGIKA MAPPING BULAN ---
    const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const revenueValues = Array(12).fill(0);

    // Pastikan rawChartData adalah array sebelum looping
    if (Array.isArray(rawChartData)) {
        rawChartData.forEach(item => {
            revenueValues[item.bulan - 1] = parseFloat(item.total);
        });
    }

    // --- 3. LOGIKA MAPPING STATUS ---
    let statusCounts = { 'selesai': 0, 'proses': 0, 'pending': 0 };
    if (Array.isArray(rawStatusData)) {
        rawStatusData.forEach(item => {
            if (statusCounts.hasOwnProperty(item.status)) {
                statusCounts[item.status] = item.total;
            }
        });
    }

    // --- 4. RENDER LINE CHART (REVENUE) ---
    const ctxLine = document.getElementById('revenueChart').getContext('2d');
    const lineGradient = ctxLine.createLinearGradient(0, 0, 0, 400);
    lineGradient.addColorStop(0, 'rgba(78, 115, 223, 0.4)');
    lineGradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Revenue",
                fill: true,
                backgroundColor: lineGradient,
                borderColor: "rgba(78, 115, 223, 1)",
                tension: 0.4,
                data: revenueValues,
            }]
        },
        options: { 
            maintainAspectRatio: false, 
            plugins: { 
                legend: { display: false } 
            } 
        }
    });

    // --- 5. RENDER DONUT CHART ---
    const ctxPie = document.getElementById('orderPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ["Selesai", "Proses", "Pending"],
            datasets: [{
                data: [statusCounts.selesai, statusCounts.proses, statusCounts.pending],
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e'],
            }],
        },
        options: { 
            maintainAspectRatio: false, 
            cutout: '75%', 
            plugins: { legend: { display: false } } 
        }
    });
</script>
@endpush
@endsection