@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-body">


<div class="d-flex justify-content-between mb-3">
    <h4>Transaksi Pelanggan</h4>
    <a href="{{ route('karyawan.transaksi.create') }}" class="btn btn-primary">
        + Tambah Transaksi
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Pelanggan</th>
            <th>Layanan</th>
            <th>Treatment</th>
            <th>Berat</th>
            <th>Status</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksis as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->user->name }}</td>
            <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
            <td>{{ $t->treatment->nama_treatment ?? '-' }}</td>
            <td>{{ $t->berat }} Kg</td>
            <td>
                <span class="badge bg-info text-dark">
                    {{ ucfirst($t->status) }}
                </span>
            </td>
            <td>
                <a href="{{ route('karyawan.transaksi.edit',$t->id) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>

               <form action="{{ route('karyawan.transaksi.destroy', $t->id) }}"
      method="POST"
      class="d-inline form-delete">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger">
        Hapus
    </button>
</form><form action="{{ route('karyawan.transaksi.destroy', $t->id) }}"
      method="POST"
      class="d-inline form-delete">
    @csrf
    @method('DELETE')

    {{-- <button type="submit" class="btn btn-sm btn-danger">
        Hapus
    </button> --}}
</form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Belum ada transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>
    </div>
</div>

{{ $transaksis->links() }}
@endsection
