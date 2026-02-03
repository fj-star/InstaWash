<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    // 1. Menampilkan daftar pelanggan
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')
            ->latest()
            ->paginate(10);

        return view('pages.karyawan.pelanggan.index', compact('pelanggans'));
    }

    // 2. Menampilkan form tambah (INI YANG TADI HILANG BEST)
    public function create()
    {
        return view('pages.karyawan.pelanggan.create');
    }

    // 3. Menyimpan data pelanggan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'no_hp'  => 'required|numeric',
            'alamat' => 'required|string',
            'ttl'    => 'required|string',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make('pelanggan123'), // Password bawaan
            'no_hp'    => $data['no_hp'],
            'alamat'   => $data['alamat'],
            'ttl'      => $data['ttl'],
            'role'     => 'pelanggan',
        ]);

        return redirect()
            ->route('karyawan.pelanggan.index')
            ->with('success', 'Pelanggan baru berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit
    public function edit(User $pelanggan)
    {
        return view('pages.karyawan.pelanggan.edit', compact('pelanggan'));
    }

    // 5. Mengupdate data pelanggan
    public function update(Request $request, User $pelanggan)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $pelanggan->id,
            'no_hp'  => 'required|numeric',
            'alamat' => 'required|string',
            'ttl'    => 'required|string',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pelanggan->update($data);

        return redirect()
            ->route('karyawan.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    // 6. Menghapus pelanggan
    public function destroy(User $pelanggan)
    {
        $pelanggan->delete();
        return back()->with('success', 'Pelanggan berhasil dihapus');
    }
}