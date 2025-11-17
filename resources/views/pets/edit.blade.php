{{-- resources/views/pets/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Hewan')
@section('header', 'Edit Data Hewan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0 text-dark">Edit: {{ $pet->name }}</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <strong>Kode Registrasi:</strong>
                    <code class="fs-6">{{ $pet->registration_code }}</code> (tidak dapat diubah)
                </div>

                <form action="{{ route('pets.update', $pet) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Pemilik Hewan <span class="text-danger">*</span></label>
                        <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}"
                                    {{ old('owner_id', $pet->owner_id) == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} - {{ $owner->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('owner_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Data Hewan --}}
                    <div class="mb-3">
                        <label class="form-label">Data Hewan <span class="text-danger">*</span></label>
                        <input type="text"
                               name="pet_data"
                               class="form-control form-control-md @error('pet_data') is-invalid @enderror"
                               value="{{ old('pet_data', $pet->name . ' ' . $pet->species . ' ' . $pet->age . 'th ' . $pet->weight . 'kg') }}"
                               placeholder="Contoh: Milo Kucing 2Th 4.5kg"
                               required>
                        @error('pet_data')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="alert alert-info mt-2 mb-0">
                            <strong><i class="bi bi-lightbulb"></i> Format Input:</strong><br>
                            <code>NAMA_HEWAN JENIS USIA BERAT</code>
                            <hr class="my-2">
                            <small>
                                <strong>Contoh:</strong> Milo Kucing 2Th 4.5kg, Bobby Anjing 3tahun 12kg
                            </small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update Data
                        </button>
                        <a href="{{ route('pets.show', $pet) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Data Saat Ini</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Kode:</th>
                        <td><code>{{ $pet->registration_code }}</code></td>
                    </tr>
                    <tr>
                        <th>Nama:</th>
                        <td>{{ $pet->name }}</td>
                    </tr>
                    <tr>
                        <th>Jenis:</th>
                        <td>{{ $pet->species }}</td>
                    </tr>
                    <tr>
                        <th>Usia:</th>
                        <td>{{ $pet->age }} tahun</td>
                    </tr>
                    <tr>
                        <th>Berat:</th>
                        <td>{{ $pet->weight }} kg</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Perhatian</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Kode registrasi tidak dapat diubah</li>
                    <li>Nama & jenis akan otomatis diubah ke UPPERCASE</li>
                    <li>Pastikan tidak ada duplikat nama dan jenis untuk pemilik yang sama</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
