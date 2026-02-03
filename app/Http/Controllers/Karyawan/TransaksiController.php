<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Menampilkan data transaksi terbaru dengan pagination
        $transaksis = Transaksi::with(['user', 'layanan', 'treatment'])
            ->latest()
            ->paginate(10);

        return view('pages.karyawan.transaksi-index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.karyawan.transaksi-create', [
            'pelanggans' => User::where('role', 'pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        $data['order_id']       = 'INV-' . strtoupper(uniqid());
        $data['created_by']     = 'karyawan';
        $data['status']         = 'pending';
        $data['payment_status'] = 'pending';

        $data['total_harga'] = $this->hitungTotalHarga(
            $data['layanan_id'],
            $data['treatment_id'] ?? null,
            $data['berat']
        );

        $trx = Transaksi::create($data);

        // Alur Midtrans InstaWash
        if ($request->metode_pembayaran === 'midtrans') {
            return redirect()->route('pelanggan.transaksi.bayar', $trx->id)
                ->with('success', 'Transaksi berhasil, silakan scan QRIS.');
        }

        return redirect()->route('karyawan.transaksi.index')
            ->with('success', 'Transaksi Cash berhasil ditambahkan');
    }

    public function edit(Transaksi $transaksi)
    {
        return view('pages.karyawan.transaksi-edit', [
            'transaksi'  => $transaksi,
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

   public function update(Request $request, Transaksi $transaksi)
{
    // 1. Validasi Status Laundry (Selalu Wajib)
    $rules = [
        'status' => 'required|in:pending,proses,selesai',
    ];

    // 2. Validasi Tambahan (Hanya jika belum bayar)
    // Kita buat nullable/opsional biar nggak bentrok sama form
    if ($transaksi->payment_status !== 'paid') {
        $rules += [
            'layanan_id'        => 'required|exists:layanans,id',
            'berat'             => 'required|numeric|min:0.1',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'metode_pembayaran' => 'nullable|in:cash,midtrans', 
        ];
    }

    $request->validate($rules);

    // 3. Update Status Laundry
    $transaksi->status = $request->status;

    // 4. Update Detail Pesanan (Jika belum bayar)
    if ($transaksi->payment_status !== 'paid') {
        $transaksi->layanan_id = $request->layanan_id;
        $transaksi->berat = $request->berat;
        
        // Update treatment & metode jika ada di input
        if ($request->has('treatment_id')) $transaksi->treatment_id = $request->treatment_id;
        if ($request->has('metode_pembayaran')) $transaksi->metode_pembayaran = $request->metode_pembayaran;

        $transaksi->total_harga = $this->hitungTotalHarga($request->layanan_id, $transaksi->treatment_id, $request->berat);
    }

    $transaksi->save(); // Simpan paksa ke database

    return redirect()->route('karyawan.transaksi.index')
        ->with('success', 'Status InstaWash Berhasil Diperbarui!');
}

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return back()->with('success', 'Transaksi berhasil dihapus');
    }

    public function konfirmasiBayar(Transaksi $transaksi)
{
    // Pastikan cuma yang cash dan masih pending yang bisa dikonfirmasi
    if ($transaksi->metode_pembayaran === 'cash' && $transaksi->payment_status === 'pending') {
        $transaksi->payment_status = 'paid';
        $transaksi->save();

        return back()->with('success', 'Pembayaran Cash Berhasil Dikonfirmasi! Lunas maseeh.');
    }

    return back()->with('error', 'Gagal konfirmasi, cek metode pembayaran.');
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

        // Diskon Otomatis InstaWash
        if ($berat >= 10 && $total >= 100000) {
            $total -= ($total * 0.1);
        }

        return round($total, 0);
    }
}