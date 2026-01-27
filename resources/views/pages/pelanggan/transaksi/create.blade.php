@extends('layouts.main')
@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden p-6 sm:p-8 lg:p-10">
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-4 border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2 sm:mb-0">
                    Buat Transaksi Baru
                </h2>
                <a href="{{ route('pelanggan.transaksi.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-full hover:bg-gray-700 transition duration-300 transform hover:scale-105 shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <form action="{{ route('pelanggan.transaksi.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="layanan_id"
                                        class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                                    <select id="layanan_id" name="layanan_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($layanans as $layanan)
                                            <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                                                {{ $layanan->nama_layanan }} - Rp
                                                {{ number_format($layanan->harga, 0, ',', '.') }}/kg</option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="treatment_id" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                                        (Opsional)</label>
                                    <select id="treatment_id" name="treatment_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Treatment</option>
                                        @foreach ($treatments as $treatment)
                                            <option value="{{ $treatment->id }}" data-harga="{{ $treatment->harga }}"
                                                data-diskon="{{ $treatment->diskon }}">{{ $treatment->nama_treatment }} -
                                                Rp {{ number_format($treatment->harga, 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                    @error('treatment_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label for="berat" class="block text-sm font-medium text-gray-700 mb-1">Berat
                                        (kg)</label>
                                    <input type="number" id="berat" name="berat" step="0.1" min="0.1"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    @error('berat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="metode_pembayaran"
                                        class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                                    <select id="metode_pembayaran" name="metode_pembayaran"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="cash">Cash</option>
                                        <option value="midtrans">QRIS / E-Wallet (Midtrans)</option>
                                    </select>
                                    @error('metode_pembayaran')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                Buat Transaksi
                            </button>
                        </div>
                    </form>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Perhitungan Harga</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga Layanan/kg</span>
                                <span class="font-medium">Rp <span id="harga-layanan">0</span></span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat</span>
                                <span class="font-medium"><span id="berat-display">0</span> kg</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal Layanan</span>
                                <span class="font-medium">Rp <span id="subtotal-layanan">0</span></span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga Treatment</span>
                                <span class="font-medium">Rp <span id="harga-treatment">0</span></span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Diskon Treatment</span>
                                <span class="font-medium text-red-600">- <span id="diskon-treatment">0</span>%</span>
                            </div>

                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diskon Tambahan</span>
                                    <span class="font-medium text-red-600">- <span id="diskon-tambahan">0</span>%</span>
                                </div>

                                <div class="flex justify-between mt-2">
                                    <span class="text-lg font-bold text-gray-800">Total Harga</span>
                                    <span class="text-lg font-bold text-blue-600">Rp <span id="total-harga">0</span></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="total_harga" id="total_harga_input" value="0">

                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                Diskon tambahan 10% akan diberikan jika berat ≥ 10kg dan total harga ≥ Rp100.000
                            </p>
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
            // Fungsi untuk menghitung total harga
            function hitungTotalHarga() {
                var layananId = $('#layanan_id').val();
                var treatmentId = $('#treatment_id').val();
                var berat = parseFloat($('#berat').val()) || 0;

                var hargaLayanan = 0;
                var hargaTreatment = 0;
                var diskonTreatment = 0;
                var diskonTambahan = 0;

                // Ambil harga layanan
                if (layananId) {
                    hargaLayanan = parseFloat($('#layanan_id option:selected').data('harga')) || 0;
                }

                // Ambil harga dan diskon treatment
                if (treatmentId) {
                    hargaTreatment = parseFloat($('#treatment_id option:selected').data('harga')) || 0;
                    diskonTreatment = parseFloat($('#treatment_id option:selected').data('diskon')) || 0;
                }

                // Hitung subtotal layanan
                var subtotalLayanan = hargaLayanan * berat;

                // Hitung total sebelum diskon
                var totalSebelumDiskon = subtotalLayanan + hargaTreatment;

                // Hitung diskon treatment
                var nilaiDiskonTreatment = 0;
                if (diskonTreatment > 0) {
                    nilaiDiskonTreatment = totalSebelumDiskon * (diskonTreatment / 100);
                }

                // Hitung total setelah diskon treatment
                var totalSetelahDiskonTreatment = totalSebelumDiskon - nilaiDiskonTreatment;

                // Hitung diskon tambahan (10% jika berat >= 10kg dan total >= 100000)
                if (berat >= 10 && totalSetelahDiskonTreatment >= 100000) {
                    diskonTambahan = 10;
                }

                var nilaiDiskonTambahan = totalSetelahDiskonTreatment * (diskonTambahan / 100);

                // Hitung total akhir
                var totalAkhir = totalSetelahDiskonTreatment - nilaiDiskonTambahan;

                // Update tampilan
                $('#harga-layanan').text(formatRupiah(hargaLayanan));
                $('#berat-display').text(berat);
                $('#subtotal-layanan').text(formatRupiah(subtotalLayanan));
                $('#harga-treatment').text(formatRupiah(hargaTreatment));
                $('#diskon-treatment').text(diskonTreatment);
                $('#diskon-tambahan').text(diskonTambahan);
                $('#total-harga').text(formatRupiah(totalAkhir));

                // Update input hidden
                $('#total_harga_input').val(totalAkhir);
            }

            // Fungsi format rupiah
            function formatRupiah(angka) {
                return angka.toLocaleString('id-ID');
            }

            // Event listener untuk perubahan input
            $('#layanan_id, #treatment_id, #berat').on('change', function() {
                hitungTotalHarga();
            });

            // Hitung total harga saat halaman dimuat
            hitungTotalHarga();
        });
    </script>
@endsection
