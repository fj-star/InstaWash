<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'layanan_id',
        'treatment_id',
        'berat',
        'total_harga',
        'order_id',
        'midtrans_transaction_id',
        'payment_type',
        'payment_status',
        'metode_pembayaran',
        'status',
        'created_by',
    ];

    /* ================= RELASI ================= */

    // pembuat transaksi (admin/karyawan/pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // pelanggan yang dilayani
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    /* ================= HELPER ================= */

    public function isPaid()
    {
        return $this->payment_status === 'settlement';
    }
}
