@extends('layouts.app')

@section('title', 'Tambah Hewan')
@section('header', 'Tambah Data Hewan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pets.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pemilik Hewan <span class="text-danger">*</span></label>
                        <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} - {{ $owner->phone }}
                                    @if($owner->phone_verified)
                                        <span class="badge bg-success">✓ Terverifikasi</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Hanya pemilik dengan nomor telepon terverifikasi yang ditampilkan
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data Hewan <span class="text-danger">*</span></label>
                        <input type="text"
                               name="pet_data"
                               class="form-control form-control-md @error('pet_data') is-invalid @enderror"
                               value="{{ old('pet_data') }}"
                               placeholder="Contoh: Milo Kucing 2Th 4.5kg"
                               required>
                        @error('pet_data')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="alert alert-info mt-2 mb-0">
                            <strong><i class="bi bi-lightbulb"></i> Format Input:</strong><br>
                            <code>NAMA_HEWAN JENIS USIA BERAT</code>
                            <hr class="my-2">
                            <strong>Contoh Valid:</strong>
                            <ul class="mb-2">
                                <li><code>Milo Kucing 2Th 4.5kg</code></li>
                                <li><code>Bobby Anjing 3tahun 12kg</code></li>
                                <li><code>Luna Golden Retriever 5thn 25,5KG</code></li>
                                <li><code>Max Kelinci 1th 2.3kg</code></li>
                            </ul>
                            <strong>Keterangan:</strong>
                            <ul class="mb-0">
                                <li><strong>Nama & Jenis:</strong> Otomatis diubah ke UPPERCASE</li>
                                <li><strong>Usia:</strong> Bisa ditulis: 2tahun, 2thn, 2th, 2Tahun, 2TH</li>
                                <li><strong>Berat:</strong> Bisa ditulis: 4.5kg, 4,5kg, 4.5 KG, 4,5KG</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Data Hewan
                        </button>
                        <a href="{{ route('pets.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    </div>
</div>
@endsection
