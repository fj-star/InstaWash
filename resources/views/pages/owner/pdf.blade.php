<!DOCTYPE html>
<html>
<head>
    <title>Laporan SiLit Laundry</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        .text-right { text-align: right; }
        .header { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN TRANSAKSI SILIT LAUNDRY</h2>
        <p>Periode: {{ $from }} s/d {{ $to }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Order ID</th>
                <th>Pelanggan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->order_id }}</td>
                <td>{{ $t->pelanggan->name ?? $t->user->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="text-right">TOTAL PENDAPATAN: Rp {{ number_format($total, 0, ',', '.') }}</h3>
</body>
</html>