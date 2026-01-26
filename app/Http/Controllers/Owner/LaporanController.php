<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * TAMPIL HALAMAN LAPORAN OWNER
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan'])
            ->where('status', 'selesai');

        // filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to   . ' 23:59:59',
            ]);
        }

        $transaksis = $query->latest()->get();

        return view('pages.owner.laporan', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $request->from,
            'to'         => $request->to,
        ]);
    }

    /**
     * EXPORT PDF LAPORAN OWNER
     */
    public function pdf(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan'])
            ->where('status', 'selesai');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to   . ' 23:59:59',
            ]);
        }

        $transaksis = $query->get();

        $pdf = Pdf::loadView('pages.owner.pdf', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $request->from,
            'to'         => $request->to,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
