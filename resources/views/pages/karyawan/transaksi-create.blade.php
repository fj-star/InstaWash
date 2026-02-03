@extends('layouts.main')
@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white"><h5>Input Transaksi Baru</h5></div>
    <div class="card-body">
        <form action="{{ route('karyawan.transaksi.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Pilih Pelanggan</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->no_hp }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control" required>
                            <option value="cash">Cash (Tunai)</option>
                            <option value="midtrans">Midtrans (QRIS/OVO/Dana)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Layanan</label>
                        <select name="layanan_id" id="layanan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($layanans as $l)
                                <option value="{{ $l->id }}" data-harga="{{ $l->harga }}">{{ $l->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Treatment</label>
                        <select name="treatment_id" id="treatment" class="form-control">
                            <option value="">-- Tanpa Treatment --</option>
                            @foreach ($treatments as $t)
                                <option value="{{ $t->id }}" data-harga="{{ $t->harga }}" data-diskon="{{ $t->diskon }}">{{ $t->nama_treatment }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Berat (Kg)</label>
                        <input type="number" name="berat" id="berat" step="0.1" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="alert alert-info">
                <h5>Total Bayar: <strong id="total_harga">Rp 0</strong></h5>
            </div>
            <button class="btn btn-primary w-100">Simpan & Proses</button>
        </form>
    </div>
</div>

<script>
    const layanan = document.getElementById('layanan');
    const treatment = document.getElementById('treatment');
    const berat = document.getElementById('berat');
    const totalEl = document.getElementById('total_harga');

    function hitung() {
        let h_layanan = layanan.value ? layanan.options[layanan.selectedIndex].dataset.harga * (berat.value || 0) : 0;
        let h_treatment = treatment.value ? parseFloat(treatment.options[treatment.selectedIndex].dataset.harga) : 0;
        let diskon = treatment.value ? parseFloat(treatment.options[treatment.selectedIndex].dataset.diskon) : 0;

        let total = h_layanan + h_treatment;
        if (diskon > 0) total -= (total * (diskon / 100));
        if (berat.value >= 10 && total >= 100000) total -= (total * 0.1);

        totalEl.innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
    }
    layanan.addEventListener('change', hitung);
    treatment.addEventListener('change', hitung);
    berat.addEventListener('input', hitung);
</script>
@endsection