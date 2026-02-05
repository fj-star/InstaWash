@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-warning py-3">
                    <h6 class="m-0 font-weight-bold text-white">Edit Absensi: {{ $absensi->user->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jam Masuk</label>
                            <input type="time" name="jam_masuk" class="form-control" value="{{ $absensi->jam_masuk }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jam Keluar</label>
                            <input type="time" name="jam_keluar" class="form-control" value="{{ $absensi->jam_keluar }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Status Kehadiran</label>
                            <select name="status" class="form-control">
                                <option value="hadir" {{ $absensi->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="terlambat" {{ $absensi->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="izin" {{ $absensi->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $absensi->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ $absensi->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Keterangan / Alasan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $absensi->keterangan }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection