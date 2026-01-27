<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>
</head>
<body>

<h3>Transaksi #{{ $transaksi->id }}</h3>
<p>Total: Rp {{ number_format($transaksi->total_harga) }}</p>

<button id="pay-button">Bayar Sekarang</button>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
            alert('Pembayaran berhasil');
            location.reload();
        },
        onPending: function (result) {
            alert('Menunggu pembayaran');
        },
        onError: function (result) {
            alert('Pembayaran gagal');
        }
    });
};
</script>

</body>
</html>
