<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = now()->toDateString();

        $totalHariIni = Transaksi::whereDate('created_at', $hariIni)->count();

        $pending = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'pending')
            ->count();

        $selesai = Transaksi::whereDate('created_at', $hariIni)
            ->where('status', 'selesai')
            ->count();

        $transaksiTerbaru = Transaksi::with('user')
            ->whereDate('created_at', $hariIni)
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.admin.karyawan.dashboard', compact(
            'totalHariIni',
            'pending',
            'selesai',
            'transaksiTerbaru'
        ));
    }
}


