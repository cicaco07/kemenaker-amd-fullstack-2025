@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')
@section('header', 'Edit Data Pemeriksaan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pemeriksaan</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('checkups.update', $checkup->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Pilih Hewan --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Hewan <span class="text-danger">*</span></label>
                            <select name="pet_id" id="petSelect"
                                class="form-select @error('pet_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Hewan --</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}"
                                        data-owner="{{ $pet->owner->name }}"
                                        data-species="{{ $pet->species }}"
                                        data-age="{{ $pet->age }}"
                                        data-weight="{{ $pet->weight }}"
                                        {{ old('pet_id', $checkup->pet_id) == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->name }} - {{ $pet->species }} ({{ $pet->owner->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pet_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Pemeriksaan --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                            <input type="date" name="checkup_date"
                                class="form-control @error('checkup_date') is-invalid @enderror"
                                value="{{ old('checkup_date', $checkup->checkup_date->format('Y-m-d')) }}"
                                required>
                            @error('checkup_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Info Hewan --}}
                    <div id="petInfo" class="alert alert-info" style="display: none;">
                        <strong><i class="bi bi-info-circle"></i> Info Hewan:</strong>
                        <div class="mt-2">
                            <span class="badge bg-light text-dark">Pemilik: <span id="petOwner">-</span></span>
                            <span class="badge bg-light text-dark">Jenis: <span id="petSpecies">-</span></span>
                            <span class="badge bg-light text-dark">Usia: <span id="petAge">-</span> tahun</span>
                            <span class="badge bg-light text-dark">Berat Terakhir: <span id="petWeight">-</span> kg</span>
                        </div>
                    </div>

                    {{-- Treatment --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Perawatan/Treatment <span class="text-danger">*</span></label>
                        <select name="treatment_id"
                            class="form-select @error('treatment_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Treatment --</option>

                            @foreach($treatments as $type => $items)
                                <optgroup label="{{ $type }}">
                                    @foreach($items as $treatment)
                                        <option value="{{ $treatment->id }}"
                                            {{ old('treatment_id', $checkup->treatment_id) == $treatment->id ? 'selected' : '' }}>
                                            {{ $treatment->name }} - Rp {{ number_format($treatment->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('treatment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Diagnosis --}}
                    <div class="mb-3">
                        <label class="form-label">Diagnosis Dokter</label>
                        <textarea name="diagnosis"
                            class="form-control @error('diagnosis') is-invalid @enderror"
                            rows="3">{{ old('diagnosis', $checkup->diagnosis) }}</textarea>
                        @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Berat --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Berat Saat Ini (kg)</label>
                            <input type="number" name="weight" step="0.01"
                                class="form-control @error('weight') is-invalid @enderror"
                                value="{{ old('weight', $checkup->weight) }}">
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Suhu --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Suhu Tubuh (°C)</label>
                            <input type="number" name="temperature" step="0.1"
                                class="form-control @error('temperature') is-invalid @enderror"
                                value="{{ old('temperature', $checkup->temperature) }}">
                            @error('temperature')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-dark">
                            <i class="bi bi-save"></i> Update Pemeriksaan
                        </button>
                        <a href="{{ route('checkups.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Panduan</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>Suhu Normal Hewan:</strong></p>
                <ul class="small mb-3">
                    <li>Anjing: 38.3 - 39.2°C</li>
                    <li>Kucing: 38.1 - 39.2°C</li>
                    <li>Kelinci: 38.5 - 40.0°C</li>
                </ul>
                <p class="small mb-0"><strong>Tips:</strong></p>
                <ul class="small mb-0">
                    <li>Timbang berat hewan secara rutin</li>
                    <li>Simpan riwayat pemeriksaan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('petSelect').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const petInfo = document.getElementById('petInfo');

    if (this.value) {
        document.getElementById('petOwner').textContent   = option.dataset.owner;
        document.getElementById('petSpecies').textContent = option.dataset.species;
        document.getElementById('petAge').textContent     = option.dataset.age;
        document.getElementById('petWeight').textContent  = option.dataset.weight;

        petInfo.style.display = 'block';
    } else {
        petInfo.style.display = 'none';
    }
});

// Auto-fill saat halaman dibuka
window.addEventListener('DOMContentLoaded', function() {
    const petSelect = document.getElementById('petSelect');
    if (petSelect.value) {
        petSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
