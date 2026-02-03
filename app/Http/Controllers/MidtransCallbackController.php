<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('ADA NOTIF MASUK DARI MIDTRANS!', $request->all());
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // 2. Inisialisasi Notifikasi
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid Notification'], 400);
        }

        $orderId = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;

        // 3. Cari Transaksi di Database
        $transaksi = Transaksi::where('order_id', $orderId)->first();

        if (!$transaksi) {
            Log::warning("Callback diterima untuk Order ID: $orderId, tapi tidak ada di database.");
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // 4. Logika Update Status (Bungkus DB Transaction biar aman)
        DB::transaction(function () use ($transactionStatus, $type, $fraud, $transaksi) {
            
            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaksi->update(['payment_status' => 'challenge']);
                    } else {
                        $transaksi->update(['payment_status' => 'paid', 'status' => 'proses']);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                // Berhasil Bayar (Biasanya dari QRIS/Bank Transfer)
                $transaksi->update([
                    'payment_status' => 'paid',
                    'status'         => 'proses' // Setelah bayar, status laundry jadi 'proses'
                ]);
            } elseif ($transactionStatus == 'pending') {
                $transaksi->update(['payment_status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $transaksi->update(['payment_status' => 'failed']);
            }
        });

        Log::info("Midtrans Callback: Order $orderId updated to $transactionStatus");

        return response()->json(['message' => 'Callback Success']);
    }
}