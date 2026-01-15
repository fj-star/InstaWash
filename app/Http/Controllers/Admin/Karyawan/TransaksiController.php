<?php

namespace App\Http\Controllers\Admin\Karyawan;

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
        $transaksis = Transaksi::with(['user','layanan','treatment'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.karyawan.transaksi-index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.admin.karyawan.transaksi-create', [
            'pelanggans' => User::where('role','pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'user_id'      => 'required|exists:users,id',
        'layanan_id'   => 'required|exists:layanans,id',
        'treatment_id' => 'nullable|exists:treatments,id',
        'berat'        => 'required|numeric|min:0.1',
    ]);

    $layanan   = Layanan::findOrFail($data['layanan_id']);
    $treatment = !empty($data['treatment_id'])
        ? Treatment::find($data['treatment_id'])
        : null;

    $hargaLayanan   = $layanan->harga * $data['berat'];
    $hargaTreatment = $treatment ? $treatment->harga : 0;
    $diskon         = $treatment ? $treatment->diskon : 0;

    $potongan = $diskon > 0
        ? ($hargaTreatment * ($diskon / 100))
        : 0;

    $total = $hargaLayanan + $hargaTreatment - $potongan;

    $data['total_harga'] = round($total);
    $data['status']     = 'pending';

    // 🔥 FIX FINAL (WAJIB)
    $data['created_by'] = 'admin';

    Transaksi::create($data);

    return redirect()
        ->route('karyawan.transaksi.index')
        ->with('success','Transaksi berhasil ditambahkan');
}


    public function edit(Transaksi $transaksi)
    {
        return view('pages.admin.karyawan.transaksi-edit', [
            'transaksi'  => $transaksi,
            'pelanggans' => User::where('role','pelanggan')->get(),
            'layanans'   => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'layanan_id'   => 'required|exists:layanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'berat'        => 'required|numeric|min:0.1',
            'status'       => 'required|in:pending,proses,selesai',
        ]);

        $layanan   = Layanan::findOrFail($data['layanan_id']);
        $treatment = !empty($data['treatment_id'])
            ? Treatment::find($data['treatment_id'])
            : null;

        $hargaLayanan   = $layanan->harga * $data['berat'];
        $hargaTreatment = $treatment ? $treatment->harga : 0;
        $diskon         = $treatment ? $treatment->diskon : 0;

        $potongan = $diskon > 0
            ? ($hargaTreatment * ($diskon / 100))
            : 0;

        $data['total_harga'] = round($hargaLayanan + $hargaTreatment - $potongan);

        $transaksi->update($data);

        return redirect()
            ->route('karyawan.transaksi.index')
            ->with('success','Transaksi berhasil diperbarui');
    }

    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->status !== 'pending') {
            return back()->with('error','Transaksi hanya bisa dihapus saat pending');
        }

        $transaksi->delete();

        return back()->with('success','Transaksi berhasil dihapus');
    }
}
