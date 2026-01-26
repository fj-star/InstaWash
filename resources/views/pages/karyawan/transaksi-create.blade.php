@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Tambah Transaksi</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('karyawan.transaksi.store') }}" method="POST">
                @csrf

                {{-- Pelanggan --}}
                <div class="mb-3">
                    <label>Pelanggan</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggans as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Layanan --}}
                <div class="mb-3">
                    <label>Layanan</label>
                    <select name="layanan_id" id="layanan" class="form-control" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($layanans as $l)
                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}">
                                {{ $l->nama_layanan }} (Rp {{ number_format($l->harga) }}/Kg)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Treatment --}}
                <div class="mb-3">
                    <label>Treatment</label>
                    <select name="treatment_id" id="treatment" class="form-control">
                        <option value="">-- Tanpa Treatment --</option>
                        @foreach ($treatments as $t)
                            <option value="{{ $t->id }}" data-harga="{{ $t->harga }}"
                                data-diskon="{{ $t->diskon }}">
                                {{ $t->nama_treatment }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Berat --}}
                <div class="mb-3">
                    <label>Berat (Kg)</label>
                    <input type="number" name="berat" id="berat" step="0.1" min="0.1" class="form-control"
                        required>

                </div>

                {{-- RINCIAN HARGA --}}
                <div class="border rounded p-3 mb-3 bg-light">
                    <p>Harga Layanan: <strong id="harga_layanan">Rp 0</strong></p>
                    <p>Harga Treatment: <strong id="harga_treatment">Rp 0</strong></p>
                    <p>Diskon: <strong id="diskon">0%</strong></p>
                    <p>Potongan Diskon: <strong class="text-danger" id="potongan">Rp 0</strong></p>
                    <hr>
                    <h5>Total Bayar: <strong id="total_harga">Rp 0</strong></h5>
                </div>

                <button class="btn btn-primary">Simpan Transaksi</button>
            </form>
        </div>
    </div>

    <script>
        const layanan = document.getElementById('layanan');
        const treatment = document.getElementById('treatment');
        const berat = document.getElementById('berat');

        const hargaLayananEl = document.getElementById('harga_layanan');
        const hargaTreatmentEl = document.getElementById('harga_treatment');
        const diskonEl = document.getElementById('diskon');
        const potonganEl = document.getElementById('potongan');
        const totalEl = document.getElementById('total_harga');

        function rupiah(num) {
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        function hitung() {
            const hargaLayanan = layanan.value ?
                layanan.options[layanan.selectedIndex].dataset.harga * berat.value :
                0;

            const hargaTreatment = treatment.value ?
                treatment.options[treatment.selectedIndex].dataset.harga :
                0;

            const diskon = treatment.value ?
                treatment.options[treatment.selectedIndex].dataset.diskon :
                0;

            let total = Number(hargaLayanan) + Number(hargaTreatment);
            let potongan = 0;

            if (diskon > 0) {
                potongan = total * (diskon / 100);
                total -= potongan;
            }

            hargaLayananEl.innerText = rupiah(hargaLayanan);
            hargaTreatmentEl.innerText = rupiah(hargaTreatment);
            diskonEl.innerText = diskon + '%';
            potonganEl.innerText = rupiah(potongan);
            totalEl.innerText = rupiah(total);
        }

        layanan.addEventListener('change', hitung);
        treatment.addEventListener('change', hitung);
        berat.addEventListener('input', hitung);
    </script>
@endsection
