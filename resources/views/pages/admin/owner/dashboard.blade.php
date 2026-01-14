@extends('layouts.main')

@section('title','Dashboard Owner')

@section('content')
<h3>Dashboard Owner</h3>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h6>Total Transaksi</h6>
            <h3>{{ $total_transaksi }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h6>Total Pendapatan</h6>
            <h3>Rp {{ number_format($total_pendapatan) }}</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Transaksi Terbaru</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Kode</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
            @foreach($transaksi as $t)
            <tr>
                <td>{{ $t->kode_transaksi }}</td>
                <td>Rp {{ number_format($t->total_harga) }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
