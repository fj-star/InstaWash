<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function pay(Transaksi $transaksi)
    {
        // proteksi
        if ($transaksi->payment_status === 'paid') {
            return back()->with('error','Transaksi sudah dibayar');
        }

        // config midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // order_id unik
        if (!$transaksi->order_id) {
            $transaksi->update([
                'order_id' => 'TRX-'.$transaksi->id.'-'.time()
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $transaksi->order_id,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => optional($transaksi->pelanggan)->name ?? 'Customer',
                'email'      => optional($transaksi->pelanggan)->email ?? 'customer@mail.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pages.midtrans.pay', compact('snapToken','transaksi'));
    }
}
