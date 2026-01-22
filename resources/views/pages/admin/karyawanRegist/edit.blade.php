@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Karyawan</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $karyawan->name) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $karyawan->email) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Password (opsional)</label>
                    <input type="password"
                           name="password"
                           class="form-control">
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password
                    </small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.karyawan.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-warning">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
