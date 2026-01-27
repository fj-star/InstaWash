@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h5>Pembayaran Transaksi</h5>
        </div>

        <div class="card-body">
            <p>
                <strong>ID Transaksi:</strong> 
                INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
            </p>

            <p>
                <strong>Total:</strong> 
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </p>

            <button id="pay-button" class="btn btn-primary">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            location.reload();
        },
        onPending: function(result){
            alert('Menunggu pembayaran');
        },
        onError: function(result){
            alert('Pembayaran gagal');
        }
    });
};
</script>
@endsection
