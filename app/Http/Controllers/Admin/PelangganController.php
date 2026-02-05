<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('user')->get();
        return view('pages.admin.customer.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pages.admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'ttl' => 'nullable|date',
        ]);

        // 1. Buat User baru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'ttl'   => $request->ttl,
            'password' => Hash::make('password123'), // default password
            'role' => 'pelanggan',
        ]);

        // 2. Buat data tambahan di tabel pelanggans
        Pelanggan::create([
            'user_id' => $user->id,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'ttl' => $request->ttl,
        ]);

        return redirect()->route('admin.pelanggans.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pages.admin.customer.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$pelanggan->user_id,
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'ttl' => 'nullable|date',
        ]);

        // Update tabel users
        $pelanggan->user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp
        ]);

        // Update tabel pelanggans
        $pelanggan->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'ttl' => $request->ttl,
        ]);

        return redirect()->route('admin.pelanggans.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
{
    // Cari dulu datanya di tabel Pelanggan
    $pelanggan = Pelanggan::findOrFail($id);
    
    // Ambil ID User-nya, lalu hapus User-nya
    // Karena di migration ada cascade, data di tabel pelanggan akan ikut terhapus
    User::findOrFail($pelanggan->user_id)->delete();

    return back()->with('success', 'Pelanggan dan akunnya berhasil dihapus, Tuan!');
}
}
