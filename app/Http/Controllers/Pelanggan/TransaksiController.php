<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['layanan', 'treatment'])
            ->where('user_id', auth()->id());

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->paginate(10);

        return view('pages.pelanggan.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.pelanggan.transaksi.create', [
            'layanans' => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        DB::transaction(function () use ($data) {
            $total = $this->hitungTotalHarga(
                $data['layanan_id'],
                $data['treatment_id'] ?? null,
                $data['berat']
            );

            Transaksi::create([
                'user_id' => auth()->id(),
                'pelanggan_id' => auth()->id(),
                'layanan_id' => $data['layanan_id'],
                'treatment_id' => $data['treatment_id'],
                'berat' => $data['berat'],
                'total_harga' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'metode_pembayaran' => $data['metode_pembayaran'],
                'created_by' => 'pelanggan',
            ]);
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat');
    }

    /**
     * ===============================
     * MIDTRANS BAYAR
     * ===============================
     */
    public function bayarMidtrans(Transaksi $transaksi)
    {
        abort_if($transaksi->user_id !== auth()->id(), 403);

        if ($transaksi->payment_status === 'paid') {
            return back()->with('error', 'Transaksi sudah dibayar');
        }

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        if (!$transaksi->order_id) {
            $transaksi->update([
                'order_id' => 'TRX-' . $transaksi->id . '-' . time(),
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->order_id,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->no_hp,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('pages.pelanggan.transaksi.bayar', compact('snapToken', 'transaksi'));
    }

    public function show($id)
{
    // Ambil data transaksi berdasarkan ID
    $transaksi = Transaksi::findOrFail($id);

    // Kembalikan ke view detail
    return view('pages.pelanggan.transaksi.show', compact('transaksi'));
}

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $treatment = $treatment_id ? Treatment::findOrFail($treatment_id) : null;

        $total = $layanan->harga * $berat;

        if ($treatment) {
            $total += $treatment->harga;
            if ($treatment->diskon > 0) {
                $total -= ($total * ($treatment->diskon / 100));
            }
        }

        return round($total, 0);
    }
}
