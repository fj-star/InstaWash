@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-lg mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0 font-weight-bold">Presensi QR InstaWash</h5>
                </div>
                <div class="card-body text-center">
                    @if(!$sudah_absen || ($sudah_absen && !$sudah_absen->jam_keluar))
                        <p class="text-muted">Arahkan kamera ke QR Code di meja Admin</p>
                        <div id="reader" class="rounded-lg shadow-inner" style="width: 100%; border: 2px dashed #4e73df;"></div>
                        
                        <form id="form-absen" action="{{ route('karyawan.absensi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="qr_code" id="qr_input">
                        </form>
                    @else
                        <div class="py-5">
                            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
                            <h4 class="font-weight-bold">Tugas Selesai!</h4>
                            <p class="text-muted">Tuan sudah absen masuk & pulang hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudah_absen->jam_masuk ?? '--:--' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pulang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudah_absen->jam_keluar ?? '--:--' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // 1. Masukkan hasil scan ke input hidden
        document.getElementById('qr_input').value = decodedText;
        
        // 2. Kirim form secara otomatis
        document.getElementById('form-absen').submit();
        
        // 3. Matikan kamera biar gak berat
        html5QrcodeScanner.clear();
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 10, 
        qrbox: 250 
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection