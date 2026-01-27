<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Treatment;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user','pelanggan','layanan','treatment'])
            ->latest()
            ->get();

        return view('pages.admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.admin.transaksi.create', [
            'pelanggans' => User::where('role','pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id'      => 'required|exists:users,id',
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        $data['user_id']        = auth()->id();
        $data['created_by']     = 'admin';
        $data['status']         = 'pending';
        $data['payment_status'] = 'pending';

        $data['total_harga'] = $this->hitungTotalHarga(
            $data['layanan_id'],
            $data['treatment_id'] ?? null,
            $data['berat']
        );

        $trx = null;

        DB::transaction(function () use ($data, &$trx) {
            $trx = Transaksi::create($data);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aksi'    => 'Tambah Transaksi',
                'keterangan' => 'ID '.$trx->id
            ]);
        });

        // 🔥 KUNCI: kalau midtrans → langsung bayar
        if ($trx->metode_pembayaran === 'midtrans') {
            return redirect()
                ->route('pelanggan.transaksi.bayar', $trx->id)
                ->with('success','Silakan lakukan pembayaran QRIS');
        }

        return redirect()->route('admin.transaksi.index')
            ->with('success','Transaksi berhasil ditambahkan');
    }

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $treatment = $treatment_id ? Treatment::find($treatment_id) : null;

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
