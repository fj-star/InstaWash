<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')
            ->latest()
            ->paginate(10);

        return view('pages.karyawan.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pages.karyawan.pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp'    => 'nullable|string|max:20',
            
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'no_hp'    => $data['no_hp'] ?? null,
            'role'     => 'pelanggan',
            'alamat'   => $request->alamat,
        ]);

        return redirect()
            ->route('karyawan.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(User $pelanggan)
    {
        return view('pages.karyawan.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, User $pelanggan)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelanggan->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat'   => $request->alamat,
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pelanggan->update($data);

        return redirect()
            ->route('karyawan.pelanggan.index')
            ->with('success', 'Data pelanggan diperbarui');
    }

    public function destroy(User $pelanggan)
    {
        $pelanggan->delete();

        return back()->with('success', 'Pelanggan berhasil dihapus');
    }
}
