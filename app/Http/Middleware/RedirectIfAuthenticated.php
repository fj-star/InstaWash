<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin'     => redirect()->route('admin.dashboard'),
                'owner'     => redirect()->route('owner.dashboard'),
                'karyawan'  => redirect()->route('karyawan.dashboard'),
                'pelanggan' => redirect()->route('pelanggan.dashboard'),
                default     => redirect('/'),
            };
        }

        return $next($request);
    }
}
