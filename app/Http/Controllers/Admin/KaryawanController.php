<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')->latest()->get();

        return view('pages.admin.karyawanRegist.index', compact('karyawans'));
    }

    public function create()
    {
        return view('pages.admin.karyawanRegist.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'karyawan',
        ]);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit(User $karyawan)
    {
        return view('pages.admin.karyawanRegist.edit', compact('karyawan'));
    }

    public function update(Request $request, User $karyawan)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
        ]);

        $karyawan->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $karyawan->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diupdate');
    }

    public function destroy(User $karyawan)
    {
        $karyawan->delete();

        return back()->with('success', 'Karyawan berhasil dihapus');
    }
}
