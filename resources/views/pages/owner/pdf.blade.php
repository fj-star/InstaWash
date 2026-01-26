<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px }
        table { width: 100%; border-collapse: collapse }
        th, td { border: 1px solid #000; padding: 5px }
        th { background: #eee }
    </style>
</head>
<body>

<h3>Laporan Transaksi</h3>

<p>
    <strong>Total Pendapatan:</strong>
    Rp {{ number_format($total,0,',','.') }}
</p>

<table>
    <thead>
        <tr>
            <th>no</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksis as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->created_at->format('d-m-Y') }}</td>
            <td>{{ $t->user->name ?? '-' }}</td>
            <td>{{ number_format($t->total_harga,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
