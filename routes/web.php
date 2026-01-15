<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ================== ADMIN ==================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\TreatmentController;

// ================== PELANGGAN ==================
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\PelangganController as UserPelangganController;
use App\Http\Controllers\Pelanggan\TransaksiController as UserTransaksiController;

// ================== OWNER & KARYAWAN ==================
use App\Http\Controllers\Admin\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Admin\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Admin\Karyawan\TransaksiController as KaryawanTransaksi;
use App\Http\Controllers\Admin\Karyawan\PelangganController;

// ================== UTIL ==================
use App\Models\Transaksi;
use App\Mail\TransaksiSelesaiMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| TEST ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/test-fonnte', function () {
    $res = Http::withHeaders([
        'Authorization' => config('services.fonnte.token'),
    ])->post('https://api.fonnte.com/send', [
        'target'  => '6285865812892',
        'message' => 'Test kirim notifikasi dari Laravel 🚀',
    ]);

    return $res->json();
});

Route::get('/test-email', function () {
    $transaksi = Transaksi::with('user','layanan')->first();
    Mail::to('alamat_email_tujuan@gmail.com')
        ->send(new TransaksiSelesaiMail($transaksi));

    return "Email test terkirim ✅";
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelanggans', AdminPelangganController::class);
    Route::resource('layanans', LayananController::class);
    Route::resource('treatments', TreatmentController::class);
    Route::resource('transaksi', AdminTransaksiController::class);
    Route::resource('log-aktivitas', LogAktivitasController::class)->only(['index', 'destroy']);
    Route::resource('laporan', LaporanController::class)->only(['index', 'destroy']);
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak.pdf');
});

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')->name('pelanggan.')->middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::resource('transaksi', UserTransaksiController::class);
});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:owner'])
    ->prefix('admin/owner')
    ->group(function () {
        Route::get('/dashboard', [OwnerDashboard::class, 'index']);
    });

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:karyawan'])
    ->prefix('admin/karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/dashboard', [KaryawanDashboard::class, 'index'])
            ->name('dashboard');

        Route::resource('transaksi', KaryawanTransaksi::class);
        Route::resource('pelanggan', PelangganController::class);
    });

require __DIR__.'/auth.php';
