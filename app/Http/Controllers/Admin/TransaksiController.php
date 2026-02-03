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
        // Memastikan relasi user (pelanggan) terpanggil
        $transaksis = Transaksi::with(['user', 'layanan', 'treatment'])
            ->latest()
            ->get();

        return view('pages.admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.admin.transaksi.create', [
            'pelanggans' => User::where('role', 'pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'           => 'required|exists:users,id', // Konsisten pakai user_id
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        // Buat Order ID Unik untuk Midtrans
        $data['order_id']       = 'INV-' . strtoupper(uniqid());
        $data['created_by']     = 'admin';
        $data['status']         = 'pending'; // Status Laundry
        $data['payment_status'] = 'pending'; // Status Bayar

        $data['total_harga'] = $this->hitungTotalHarga(
            $data['layanan_id'],
            $data['treatment_id'] ?? null,
            $data['berat']
        );

        $trx = DB::transaction(function () use ($data) {
            $trx = Transaksi::create($data);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aksi'    => 'Tambah Transaksi',
                'keterangan' => 'ID Transaksi: '.$trx->id . ' ('.$data['order_id'].')'
            ]);

            return $trx;
        });

        if ($request->metode_pembayaran === 'midtrans') {
            return redirect()
                ->route('pelanggan.transaksi.bayar', $trx->id)
                ->with('success', 'Transaksi dibuat. Silakan scan QRIS untuk pelanggan.');
        }

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi Cash berhasil ditambahkan');
    }

    public function edit(Transaksi $transaksi)
    {
        return view('pages.admin.transaksi.edit', [
            'transaksi'  => $transaksi,
            'pelanggans' => User::where('role', 'pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

   public function update(Request $request, Transaksi $transaksi)
{
    // Validasi data yang boleh diedit
    $rules = [
        'status' => 'required|in:pending,proses,selesai',
    ];

    // Jika belum lunas, izinkan edit detail pesanan & harga
    if ($transaksi->payment_status !== 'paid') {
        $rules += [
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ];
    }

    $data = $request->validate($rules);

    // Hitung ulang harga jika belum lunas
    if ($transaksi->payment_status !== 'paid') {
        $data['total_harga'] = $this->hitungTotalHarga(
            $request->layanan_id,
            $request->treatment_id,
            $request->berat
        );
    }

    // Eksekusi Update
    $transaksi->update($data);

    return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi InstaWash berhasil diperbarui!');
}

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return back()->with('success', 'Transaksi berhasil dihapus');
    }

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $total = $layanan->harga * $berat;

        if ($treatment_id) {
            $treatment = Treatment::find($treatment_id);
            if ($treatment) {
                $total += $treatment->harga;
                if ($treatment->diskon > 0) {
                    $total -= ($total * ($treatment->diskon / 100));
                }
            }
        }

        // Tambahan Diskon 10% jika berat >= 10kg
        if ($berat >= 10 && $total >= 100000) {
            $total -= ($total * 0.1);
        }

        return round($total, 0);
    }
}