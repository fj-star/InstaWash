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
        $transaksis = Transaksi::with(['pelanggan','layanan','treatment'])
            ->latest()
            ->paginate(10);

        return view('pages.karyawan.transaksi-index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.karyawan.transaksi-create', [
            'pelanggans' => User::where('role','pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id' => 'required|exists:users,id',
            'layanan_id'   => 'required|exists:layanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'berat'        => 'required|numeric|min:0.1',
        ]);

        $data['user_id']          = auth()->id();
        $data['created_by']       = 'karyawan';
        $data['status']           = 'pending';
        $data['metode_pembayaran']= 'cash';
        $data['payment_status']   = 'pending';

        $data['total_harga'] = $this->hitungTotalHarga(
            $data['layanan_id'],
            $data['treatment_id'] ?? null,
            $data['berat']
        );

        Transaksi::create($data);

        return redirect()->route('karyawan.transaksi.index')
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
