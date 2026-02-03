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
            'no_hp'    => 'required|numeric', // Tambahan
            'alamat'   => 'required|string',  // Tambahan
            'ttl'      => 'required|string',  // Tambahan (Tempat, Tanggal Lahir)
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'ttl'      => $request->ttl,
            'role'     => 'karyawan',
        ]);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan InstaWash berhasil ditambahkan');
    }

    public function edit(User $karyawan)
    {
        return view('pages.admin.karyawanRegist.edit', compact('karyawan'));
    }

    public function update(Request $request, User $karyawan)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $karyawan->id,
            'no_hp'  => 'required|numeric',
            'alamat' => 'required|string',
            'ttl'    => 'required|string',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'ttl'    => $request->ttl,
        ];

        // Jika password diisi, baru kita update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);

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