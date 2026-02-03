@extends('layouts.main')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Edit Data Pelanggan InstaWash</h6>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('karyawan.pelanggan.update',$pelanggan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $pelanggan->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Email</label>
                                <input type="email" name="email" value="{{ old('email', $pelanggan->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Nomor HP</label>
                                <input type="number" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" class="form-control @error('no_hp') is-invalid @enderror" required>
                                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Tempat, Tanggal Lahir</label>
                                <input type="text" name="ttl" value="{{ old('ttl', $pelanggan->ttl) }}" class="form-control @error('ttl') is-invalid @enderror" required>
                                @error('ttl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Ganti Password (Opsional)</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin ganti">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('karyawan.pelanggan.index') }}" class="btn btn-secondary shadow-sm">Kembali</a>
                        <button type="submit" class="btn btn-warning text-dark font-weight-bold shadow-sm"><i class="fas fa-sync"></i> Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection