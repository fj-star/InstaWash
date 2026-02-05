<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    $now = \Carbon\Carbon::now();

    // Pastikan hasil query selalu collection/array (jangan biarkan null)
    $chartData = Transaksi::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(total_harga) as total')
        )
        ->whereYear('created_at', $now->year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('bulan')
        ->get() ?? collect([]); // Jika kosong, beri collection kosong

    $statusData = Transaksi::select('status', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->get() ?? collect([]);

    return view('pages.owner.dashboard', [
        'total_transaksi'  => Transaksi::count(),
        'omset_bulan_ini'  => Transaksi::whereMonth('created_at', $now->month)->sum('total_harga') ?? 0,
        'pesanan_proses'   => Transaksi::whereIn('status', ['pending', 'proses'])->count() ?? 0,
        'total_pelanggan'  => \App\Models\User::where('role', 'pelanggan')->count() ?? 0,
        'transaksis'       => Transaksi::with('pelanggan')->latest()->limit(5)->get(),
        'chartData'        => $chartData,
        'statusData'       => $statusData
    ]);
}
}