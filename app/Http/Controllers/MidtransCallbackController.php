<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // config midtrans
        Config::$serverKey = config('services.midtrans.server_key');

        $payload = $request->all();

        // ambil data penting
        $orderId           = $payload['order_id'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;

        // VALIDASI SIGNATURE (WAJIB)
        $serverKey = config('services.midtrans.server_key');
        $hash = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if ($hash !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // cari transaksi
        $transaksi = Transaksi::where('order_id', $orderId)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        /**
         * MAPPING STATUS MIDTRANS
         */
        if (
            $transactionStatus === 'capture' ||
            $transactionStatus === 'settlement'
        ) {
            // BERHASIL
            $transaksi->update([
                'payment_status' => 'paid',
                'payment_type'   => $paymentType,
                'status'         => 'proses',
            ]);
        }
        elseif ($transactionStatus === 'pending') {
            $transaksi->update([
                'payment_status' => 'pending',
            ]);
        }
        elseif (
            $transactionStatus === 'deny' ||
            $transactionStatus === 'expire' ||
            $transactionStatus === 'cancel'
        ) {
            $transaksi->update([
                'payment_status' => 'failed',
                'status'         => 'batal',
            ]);
        }

        return response()->json(['message' => 'Callback success']);
    }
}
