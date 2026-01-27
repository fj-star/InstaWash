<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaksi;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken(Transaksi $transaksi)
    {
        if (!$transaksi->order_id) {
            $transaksi->update([
                'order_id' => 'TRX-' . $transaksi->id . '-' . time()
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->order_id,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name ?? 'Customer',
                'email' => $transaksi->user->email ?? 'customer@mail.com',
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
