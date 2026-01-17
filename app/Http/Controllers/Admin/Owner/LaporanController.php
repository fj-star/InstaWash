<?php

namespace App\Http\Controllers\Admin\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('user')
            ->where('status', 'selesai');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to   . ' 23:59:59',
            ]);
        }

        $transaksis = $query->latest()->get();

        return view('pages.admin.owner.laporan', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $request->from,
            'to'         => $request->to,
        ]);
    }

    public function pdf(Request $request)
    {
        $query = Transaksi::with('user')
            ->where('status', 'selesai');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to   . ' 23:59:59',
            ]);
        }

        $transaksis = $query->get();

        $pdf = PDF::loadView('pages.admin.owner.laporan-pdf', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $request->from,
            'to'         => $request->to,
        ]);

        return $pdf->download('laporan-transaksi.pdf');
    }
}
