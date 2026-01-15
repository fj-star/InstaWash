@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Pelanggan</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('karyawan.pelanggan.update',$pelanggan->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name"
                       value="{{ $pelanggan->name }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ $pelanggan->email }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp"
                       value="{{ $pelanggan->no_hp }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Password (Opsional)</label>
                <input type="password" name="password"
                       class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('karyawan.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
