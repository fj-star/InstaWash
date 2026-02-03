@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">InstaWash - Tambah Transaksi</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Transaksi Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi.store') }}" method="POST" id="createTransaksiForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="user_id">Pelanggan <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach($pelanggans as $p)
                                            <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} ({{ $p->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="layanan_id">Layanan <span class="text-danger">*</span></label>
                                    <select name="layanan_id" id="layanan_id" class="form-control @error('layanan_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($layanans as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_layanan }} - Rp {{ number_format($l->harga, 0, ',', '.') }}/kg
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="treatment_id">Treatment (Opsional)</label>
                                    <select name="treatment_id" id="treatment_id" class="form-control @error('treatment_id') is-invalid @enderror">
                                        <option value="">-- Tanpa Treatment --</option>
                                        @foreach($treatments as $t)
                                            <option value="{{ $t->id }}" data-harga="{{ $t->harga }}" data-diskon="{{ $t->diskon }}" {{ old('treatment_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->nama_treatment }} (+Rp {{ number_format($t->harga, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="berat">Berat (kg) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="berat" id="berat" class="form-control @error('berat') is-invalid @enderror" value="{{ old('berat') }}" step="0.1" min="0.1" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                    @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="metode_pembayaran">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash (Bayar di Toko)</option>
                                        <option value="midtrans" {{ old('metode_pembayaran') == 'midtrans' ? 'selected' : '' }}>Midtrans (QRIS/OVO/Dana)</option>
                                    </select>
                                    @error('metode_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="status">Status Pengerjaan <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="pending">Pending (Antrean)</option>
                                        <option value="proses">Proses Cucian</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Buat Transaksi InstaWash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 font-weight-bold text-dark">Ringkasan Biaya</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td>Subtotal Layanan</td><td class="text-end text-primary font-weight-bold">Rp <span id="subtotal-layanan">0</span></td></tr>
                        <tr><td>Biaya Treatment</td><td class="text-end text-primary font-weight-bold">Rp <span id="harga-treatment">0</span></td></tr>
                        <tr><td>Diskon Treatment</td><td class="text-end text-danger">- <span id="diskon-treatment">0</span>%</td></tr>
                        <hr>
                        <tr class="h5"><td>Total Akhir</td><td class="text-end text-success font-weight-bold">Rp <span id="total-harga">0</span></td></tr>
                    </table>
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle"></i> Diskon 10% otomatis jika berat ≥ 10kg & total ≥ Rp100rb.
                    </div>
                </div>
            </div>
        </div>
    </div>
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

            // Diskon Spesial InstaWash
            if (berat >= 10 && total >= 100000) {
                total -= (total * 0.1);
            }

            $('#subtotal-layanan').text(subtotalLayanan.toLocaleString('id-ID'));
            $('#harga-treatment').text(hargaTreatment.toLocaleString('id-ID'));
            $('#diskon-treatment').text(diskonTreatment);
            $('#total-harga').text(Math.round(total).toLocaleString('id-ID'));
        }

        $('#layanan_id, #treatment_id, #berat').on('change keyup', hitungTotal);
    });
</script>
@endsection