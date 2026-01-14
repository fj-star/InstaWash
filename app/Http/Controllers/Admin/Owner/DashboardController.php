<?php

namespace App\Http\Controllers\Admin\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.owner.dashboard', [
            'total_transaksi' => Transaksi::count(),
            'total_pendapatan' => Transaksi::sum('total_harga'),
            'transaksi' => Transaksi::latest()->limit(10)->get()
        ]);
    }
}

