<?php

namespace App\Http\Controllers\Admin\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // grafik pendapatan per bulan
        $pendapatanBulanan = Transaksi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return view('pages.admin.owner.dashboard', [
            'total_transaksi'   => Transaksi::count(),
            'total_pendapatan'  => Transaksi::sum('total_harga'),
            'transaksis'        => Transaksi::latest()->limit(10)->get(),
            'chartData'         => $pendapatanBulanan
        ]);
    }
}
