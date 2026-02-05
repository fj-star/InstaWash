<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Pastikan menggunakan zona waktu Asia/Jakarta yang sudah kita set di config
        $today = Carbon::today()->toDateString();
        
        // 1. Ambil Statistik (Hanya untuk Hari Ini)
        $stats = [
            'total_karyawan' => User::where('role', 'karyawan')->count(),
            // Hadir & Terlambat masuk ke kotak 'Hadir'
            'hadir'          => Absensi::where('tanggal', $today)->whereIn('status', ['hadir', 'terlambat'])->count(),
            'terlambat'      => Absensi::where('tanggal', $today)->where('status', 'terlambat')->count(),
            // Izin, Sakit, & Alpha masuk ke kotak 'Izin/Sakit/Cuti'
            'izin'           => Absensi::where('tanggal', $today)->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
        ];

        // 2. Ambil Data Tabel (Hanya untuk Hari Ini agar Tab 'Monitoring Hari Ini' Akurat)
        $absensis = Absensi::with('user')
                    ->where('tanggal', $today)
                    ->latest()
                    ->paginate(20);

        return view('pages.admin.absensi.index', compact('absensis', 'stats'));
    }

    public function edit($id)
    {
        // Cari data absensi berdasarkan ID
        $absensi = Absensi::with('user')->findOrFail($id);
        return view('pages.admin.absensi.edit', compact('absensi'));
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status'  => 'required|in:izin,sakit,alpha', // Sesuaikan dengan Enum Migration Tuan
            'keterangan' => 'nullable'
        ]);

        // Cek apakah hari ini user tersebut sudah ada datanya?
        $exists = Absensi::where('user_id', $request->user_id)
                         ->where('tanggal', Carbon::today()->toDateString())
                         ->exists();

        if ($exists) {
            return back()->with('error', 'Karyawan ini sudah memiliki data absensi hari ini, Tuan!');
        }

        Absensi::create([
            'user_id'    => $request->user_id,
            'tanggal'    => Carbon::today()->toDateString(),
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
            'jam_masuk'  => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Data absensi manual berhasil dicatat, Tuan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'jam_masuk' => 'nullable',
            'jam_keluar' => 'nullable',
        ]);

        $absensi = Absensi::findOrFail($id);
        
        $absensi->update([
            'jam_masuk'  => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.absensi.index')->with('success', 'Data berhasil diperbarui, Tuan!');
    }

    public function getStats()
{
    $today = \Carbon\Carbon::today()->toDateString();
    return response()->json([
        'total_karyawan' => \App\Models\User::where('role', 'karyawan')->count(),
        'hadir'          => \App\Models\Absensi::where('tanggal', $today)->whereIn('status', ['hadir', 'terlambat'])->count(),
        'terlambat'      => \App\Models\Absensi::where('tanggal', $today)->where('status', 'terlambat')->count(),
        'izin'           => \App\Models\Absensi::where('tanggal', $today)->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
    ]);
}
}