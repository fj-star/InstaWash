<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Fungsi Pertama: Menampilkan Monitoring Absensi
     * Admin bisa melihat siapa yang hadir hari ini atau tanggal tertentu
     */
    public function index()
{
    $today = \Carbon\Carbon::today()->toDateString();
    
    // Data untuk Stats Cards
    $stats = [
        'total_karyawan' => \App\Models\User::where('role', 'karyawan')->count(),
        'hadir' => Absensi::where('tanggal', $today)->whereIn('status', ['hadir', 'terlambat'])->count(),
        'terlambat' => Absensi::where('tanggal', $today)->where('status', 'terlambat')->count(),
        'izin' => Absensi::where('tanggal', $today)->whereIn('status', ['izin', 'sakit'])->count(),
    ];

    $absensis = Absensi::with('user')->latest()->paginate(20);
    return view('pages.admin.absensi.index', compact('absensis', 'stats'));
}

    /**
     * Fungsi Kedua: Edit Data (Koreksi)
     * Kalau karyawan lupa klik 'Pulang', Admin yang benerin di sini
     */
    public function edit(Absensi $absensi)
    {
        return view('pages.admin.absensi.edit', compact('absensi'));
    }

    /**
     * Fungsi Ketiga: Update Data
     */
   public function storeManual(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'status' => 'required|in:izin,sakit,cuti,alpha',
        'keterangan' => 'nullable'
    ]);

    Absensi::create([
        'user_id' => $request->user_id,
        'tanggal' => \Carbon\Carbon::today()->toDateString(),
        'status' => $request->status,
        'keterangan' => $request->keterangan,
        'jam_masuk' => \Carbon\Carbon::now()->toTimeString(),
    ]);

    return back()->with('success', 'Data absensi manual berhasil dicatat, Tuan!');
}

// 2. Update Data Absensi (Jika ada yang salah jam atau status)
public function update(Request $request, $id)
{
    $absensi = Absensi::findOrFail($id);
    
    $absensi->update([
        'jam_masuk' => $request->jam_masuk,
        'jam_keluar' => $request->jam_keluar,
        'status' => $request->status,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('admin.absensi.index')->with('success', 'Data berhasil diperbarui!');
}
    
}