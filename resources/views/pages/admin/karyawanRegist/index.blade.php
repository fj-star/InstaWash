@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Karyawan</h1>

    <a href="{{ route('admin.karyawan.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Karyawan
    </a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($karyawans as $karyawan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $karyawan->name }}</td>
                        <td>{{ $karyawan->email }}</td>
                        <td>
    <!-- EDIT -->
    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}"
       class="btn btn-warning btn-sm">
        Edit
    </a>

    <!-- DELETE -->
    <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Yakin hapus karyawan ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">
            Hapus
        </button>
    </form>
</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
