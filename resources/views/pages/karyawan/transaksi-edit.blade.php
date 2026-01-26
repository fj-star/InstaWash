@extends('layouts.main')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Transaksi</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('karyawan.transaksi.update', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pelanggan --}}
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('user_id', $transaksi->user_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Layanan --}}
                    <div class="mb-3">
                        <label class="form-label">Layanan</label>
                        <select name="layanan_id" class="form-control" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanans as $l)
                                <option value="{{ $l->id }}"
                                    {{ old('layanan_id', $transaksi->layanan_id) == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Treatment --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Treatment <small class="text-muted">(Opsional)</small>
                        </label>
                        <select name="treatment_id" class="form-control">
                            <option value="">-- Tanpa Treatment --</option>
                            @foreach($treatments as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('treatment_id', $transaksi->treatment_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->nama_treatment }}
                                </option>
                            @endforeach
                        </select>
                        @error('treatment_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Berat --}}
                    <div class="mb-3">
                        <label class="form-label">Berat (Kg)</label>
                        <input type="number"
                               step="0.1"
                               min="0.1"
                               name="berat"
                               class="form-control"
                               value="{{ old('berat', $transaksi->berat) }}"
                               required>
                        @error('berat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status Transaksi</label>
                        <select name="status" class="form-control" required>
                            <option value="pending"
                                {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="proses"
                                {{ old('status', $transaksi->status) == 'proses' ? 'selected' : '' }}>
                                Proses
                            </option>
                            <option value="selesai"
                                {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Button --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('karyawan.transaksi.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Transaksi
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
