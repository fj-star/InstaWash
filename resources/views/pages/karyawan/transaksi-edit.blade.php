@extends('layouts.main')
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow border-left-warning">
    <div class="card-header"><h5>Edit Transaksi #{{ $transaksi->order_id }}</h5></div>
    <div class="card-body">
        <form action="{{ route('karyawan.transaksi.update', $transaksi->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <label class="fw-bold">Nama Pelanggan</label>
                    <p class="form-control bg-light">{{ $transaksi->user->name ?? 'Pelanggan' }}</p>
                    
                    <label>Status Laundry</label>
                    <select name="status" id="status" class="form-control border-primary" required>
                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-6">
                    @if($transaksi->payment_status !== 'paid')
                        <label>Layanan</label>
                        <select name="layanan_id" class="form-control mb-2">
                            @foreach($layanans as $l)
                                <option value="{{ $l->id }}" {{ $transaksi->layanan_id == $l->id ? 'selected' : '' }}>{{ $l->nama_layanan }}</option>
                            @endforeach
                        </select>
                        <label>Berat (Kg)</label>
                        <input type="number" name="berat" step="0.1" class="form-control mb-2" value="{{ $transaksi->berat }}">
                        
                        
                        <input type="hidden" name="metode_pembayaran" value="{{ $transaksi->metode_pembayaran }}">
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Transaksi Lunas. Detail pesanan (Layanan/Berat) dikunci untuk keamanan data.
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-warning w-100 mt-3 font-weight-bold shadow-sm">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection