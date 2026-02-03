<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Pastikan waktu sekarang menggunakan timezone Indonesia
        $today = Carbon::today()->toDateString();
        
        if ($user->role === 'admin') {
            $absensis = Absensi::with('user')->latest()->paginate(20);
            return view('pages.admin.absensi.index', compact('absensis'));
        }

        // Untuk Karyawan
        $absensis = Absensi::where('user_id', $user->id)->latest()->paginate(10);
        $sudah_absen = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
        
        return view('pages.karyawan.absensi.index', compact('absensis', 'sudah_absen'));
    }

   public function store(Request $request)
{
    $request->validate(['qr_code' => 'required']);

    $now = \Carbon\Carbon::now();
    $today = $now->toDateString();
    $timeString = $now->toTimeString();

    // Validasi QR Code tetap sama
    $kodeValid = 'ABSEN-INSTAWASH-' . $today;
    if ($request->qr_code !== $kodeValid) {
        return back()->with('error', 'Wah, QR Code-nya salah maseeh!');
    }

    $user_id = auth()->id();
    // Cari data absen user hari ini
    $absen = Absensi::where('user_id', $user_id)->where('tanggal', $today)->first();

    if (!$absen) {
        // --- JIKA BELUM ADA DATA = ABSEN MASUK ---
        $batasMasuk = \Carbon\Carbon::createFromTimeString('08:00:00');
        $status = $now->gt($batasMasuk) ? 'terlambat' : 'hadir';

        Absensi::create([
            'user_id'   => $user_id,
            'tanggal'   => $today,
            'jam_masuk' => $timeString,
            'status'    => $status
        ]);

        return redirect()->route('karyawan.absensi.index')->with('success', 'Berhasil Absen MASUK jam ' . $timeString);

    } else {
        // --- JIKA SUDAH ADA DATA = CEK UNTUK ABSEN PULANG ---
        
        // 1. Cek kalau dia sudah pernah absen pulang (biar nggak scan berkali-kali)
        if ($absen->jam_keluar) {
            return redirect()->route('karyawan.absensi.index')->with('info', 'Tuan sudah menyelesaikan tugas hari ini.');
        }

        // 2. Update jam keluar
        $absen->update([
            'jam_keluar' => $timeString
        ]);

        return redirect()->route('karyawan.absensi.index')->with('success', 'Berhasil Absen PULANG jam ' . $timeString . '. Hati-hati di jalan Tuan!');
    }
}
}