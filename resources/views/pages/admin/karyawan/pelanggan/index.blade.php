@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Data Pelanggan</h5>
        <a href="{{ route('karyawan.pelanggan.create') }}" class="btn btn-primary">
            + Tambah Pelanggan
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->phone }}</td>
                    <td>
                        <a href="{{ route('karyawan.pelanggan.edit',$p->id) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('karyawan.pelanggan.destroy',$p->id) }}"
                              method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pelanggans->links() }}
    </div>
</div>
@endsection
