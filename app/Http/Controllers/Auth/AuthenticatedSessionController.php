<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi kredensial
        $request->authenticate();

        // Regenerasi session setelah login untuk keamanan
        $request->session()->regenerate();

        // Ambil data user yang sudah login
        $user = Auth::user(); // lebih aman dari $request->user()

        // Pastikan user ada
        if (!$user) {
            return back()->withErrors([
                'email' => 'Login gagal. Silakan coba lagi.',
            ])->onlyInput('email');
        }

        // Redirect sesuai role
        return match ($user->role) {
            'admin'     => redirect()->route('admin.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'pelanggan' => redirect()->route('pelanggan.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'owner' => redirect('/admin/owner/dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'karyawan' => redirect('/admin/karyawan/dashboard')->with('success', 'Halo ' . auth()->user()->name),
            default     => redirect('/'),
        };
    }

    /**
     * Proses logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('logout_success', 'Anda berhasil logout, sampai jumpa lagi!');
    }
    
}
