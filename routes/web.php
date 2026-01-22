<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\KaryawanController;

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\LaporanController as OwnerLaporan;

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\TransaksiController as KaryawanTransaksi;
use App\Http\Controllers\Karyawan\PelangganController as KaryawanPelanggan;

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Pelanggan\TransaksiController as PelangganTransaksi;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| PROFILE (ALL AUTH USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('pelanggans', AdminPelanggan::class);
        Route::resource('layanans', LayananController::class);
        Route::resource('treatments', TreatmentController::class);
        Route::resource('transaksi', AdminTransaksi::class);
        Route::resource('karyawan', KaryawanController::class);

        Route::resource('log-aktivitas', LogAktivitasController::class)
            ->only(['index','destroy']);

        Route::resource('laporan', AdminLaporan::class)
            ->only(['index','destroy']);

        Route::get('laporan/cetak', [AdminLaporan::class, 'cetakPdf'])
            ->name('laporan.cetak.pdf');
    });

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::prefix('owner')
    ->name('owner.')
    ->middleware(['auth','role:owner'])
    ->group(function () {

        Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');

        Route::get('/laporan', [OwnerLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [OwnerLaporan::class, 'pdf'])->name('laporan.pdf');
    });

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
Route::prefix('karyawan')
    ->name('karyawan.')
    ->middleware(['auth','role:karyawan'])
    ->group(function () {

        Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('dashboard');

        Route::resource('transaksi', KaryawanTransaksi::class);
        Route::resource('pelanggan', KaryawanPelanggan::class);
    });

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->middleware(['auth','role:pelanggan'])
    ->group(function () {

        Route::get('/dashboard', [PelangganDashboard::class, 'index'])->name('dashboard');

        Route::resource('transaksi', PelangganTransaksi::class);
    });

require __DIR__.'/auth.php';
