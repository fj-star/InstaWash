<?php

namespace App\Mail;

use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransaksiSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Terimakasih,Pesanan Laundry Anda Selesai ✅')
            ->view('emails.transaksi_selesai');
    }
}
