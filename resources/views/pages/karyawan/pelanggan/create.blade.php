@extends('layouts.main')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Tambah Pelanggan Baru</h6>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('karyawan.pelanggan.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama pelanggan" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Nomor HP <span class="text-danger">*</span></label>
                                <input type="number" name="no_hp" value="{{ old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror" placeholder="0812xxx" required>
                                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Tempat, Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="ttl" value="{{ old('ttl') }}" class="form-control @error('ttl') is-invalid @enderror" placeholder="Contoh: Bandung, 01-01-2000" required>
                                @error('ttl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                                <small class="text-muted">Gunakan password standar (misal: pelanggan123)</small>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Masukkan alamat lengkap pelanggan" required>{{ old('alamat') }}</textarea>
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('karyawan.pelanggan.index') }}" class="btn btn-secondary shadow-sm">Batal</a>
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-save"></i> Simpan Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection