@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Transaksi #INV{{ $transaksi->id }}</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
        @csrf 
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4 border-left-warning">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan InstaWash</h6>
                    </div>
                    <div class="card-body">
                        @if($transaksi->payment_status == 'paid')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Transaksi ini sudah <b>LUNAS</b>. Anda hanya dapat mengubah <b>Status Pengerjaan</b>.
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Pelanggan</label>
                                    <input type="text" class="form-control bg-light" value="{{ $transaksi->user?->name }}" readonly>
                                    <small class="text-muted">*Nama pelanggan tidak dapat diubah</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="layanan_id">Layanan</label>
                                    <select name="layanan_id" id="layanan_id" class="form-control" {{ $transaksi->payment_status == 'paid' ? 'disabled' : 'required' }}>
                                        @foreach($layanans as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}" {{ $transaksi->layanan_id == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="treatment_id">Treatment</label>
                                    <select name="treatment_id" id="treatment_id" class="form-control" {{ $transaksi->payment_status == 'paid' ? 'disabled' : '' }}>
                                        <option value="">-- Tanpa Treatment --</option>
                                        @foreach($treatments as $t)
                                            <option value="{{ $t->id }}" data-harga="{{ $t->harga }}" data-diskon="{{ $t->diskon }}" {{ $transaksi->treatment_id == $t->id ? 'selected' : '' }}>
                                                {{ $t->nama_treatment }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="berat">Berat (kg)</label>
                                    <input type="number" name="berat" id="berat" class="form-control" value="{{ $transaksi->berat }}" step="0.1" {{ $transaksi->payment_status == 'paid' ? 'readonly' : 'required' }}>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" class="form-control" {{ $transaksi->payment_status == 'paid' ? 'disabled' : 'required' }}>
                                        <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="midtrans" {{ $transaksi->metode_pembayaran == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="text-primary font-weight-bold">Status Pengerjaan Laundry</label>
                                    <select name="status" id="status" class="form-control border-primary" required>
                                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending (Antrean)</option>
                                        <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses (Sedang Dicuci)</option>
                                        <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai (Siap Ambil)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-warning text-dark font-weight-bold shadow-sm">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-light">
                        <h6 class="m-0 font-weight-bold text-primary">Info Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <p>Status Bayar: 
                            <span class="badge {{ $transaksi->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ strtoupper($transaksi->payment_status) }}
                            </span>
                        </p>
                        <hr>
                        <div class="d-flex justify-content-between h5">
                            <span>Total Harga:</span>
                            <span class="text-success font-weight-bold">Rp <span id="total-harga">{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function hitungTotal() {
            let berat = parseFloat($('#berat').val()) || 0;
            let hargaLayanan = parseFloat($('#layanan_id option:selected').data('harga')) || 0;
            let hargaTreatment = parseFloat($('#treatment_id option:selected').data('harga')) || 0;
            let diskonTreatment = parseFloat($('#treatment_id option:selected').data('diskon')) || 0;

            let subtotalLayanan = hargaLayanan * berat;
            let total = subtotalLayanan + hargaTreatment;

            if (diskonTreatment > 0) {
                total -= (total * (diskonTreatment / 100));
            }

            // Diskon 10% jika berat >= 10kg
            if (berat >= 10 && total >= 100000) {
                total -= (total * 0.1);
            }

            $('#total-harga').text(Math.round(total).toLocaleString('id-ID'));
        }

        $('#layanan_id, #treatment_id, #berat').on('change keyup', hitungTotal);
    });
</script>
@endsection