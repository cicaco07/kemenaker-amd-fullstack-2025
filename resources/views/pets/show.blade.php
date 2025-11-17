@extends('layouts.app')

@section('title', 'Detail Hewan')
@section('header', 'Detail Hewan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-heart-fill"></i> {{ $pet->name }}</h5>
                <span class="badge bg-light text-dark">{{ $pet->registration_code }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Kode Registrasi:</th>
                                <td><code class="fs-5 text-primary">{{ $pet->registration_code }}</code></td>
                            </tr>
                            <tr>
                                <th>Nama Hewan:</th>
                                <td><strong>{{ $pet->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Jenis:</th>
                                <td><span class="badge bg-info">{{ $pet->species }}</span></td>
                            </tr>
                            <tr>
                                <th>Ras/Breed:</th>
                                <td>{{ $pet->breed ?? '-' }}</td>
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
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Jenis Kelamin:</th>
                                <td>{{ $pet->gender ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Warna:</th>
                                <td>{{ $pet->color ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir:</th>
                                <td>{{ $pet->birth_date ? $pet->birth_date->format('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Terdaftar:</th>
                                <td>{{ $pet->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Update Terakhir:</th>
                                <td>{{ $pet->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><i class="bi bi-person"></i> Informasi Pemilik</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Nama:</strong> {{ $pet->owner->name }}</p>
                                <p class="mb-2"><strong>Telepon:</strong> {{ $pet->owner->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Email:</strong> {{ $pet->owner->email ?? '-' }}</p>
                                <p class="mb-2"><strong>Alamat:</strong> {{ $pet->owner->address }}</p>
                            </div>
                        </div>
                        <a href="{{ route('owners.show', $pet->owner) }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-arrow-right"></i> Lihat Detail Pemilik
                        </a>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Data
                    </a>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus data hewan ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-clipboard2-pulse"></i> Riwayat Pemeriksaan</h6>
            </div>
            <div class="card-body">
                @forelse($pet->checkups as $checkup)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $checkup->checkup_date->format('d/m/Y') }}</strong>
                        <span class="badge bg-primary">{{ $checkup->treatment->name }}</span>
                    </div>
                    @if($checkup->diagnosis)
                    <p class="small text-muted mb-1 mt-2">{{ Str::limit($checkup->diagnosis, 80) }}</p>
                    @endif
                    <a href="{{ route('checkups.show', $checkup) }}" class="btn btn-sm btn-outline-info">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @empty
                <p class="text-center text-muted py-3 mb-0">
                    Belum ada riwayat pemeriksaan
                </p>
                @endforelse

                @if($pet->checkups->count() > 0)
                <a href="{{ route('checkups.index') }}" class="btn btn-sm btn-primary w-100 mt-2">
                    <i class="bi bi-clipboard-plus"></i> Tambah Pemeriksaan
                </a>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-shield-check"></i> Kode Registrasi</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="display-6 text-primary mb-2">
                        <code>{{ $pet->registration_code }}</code>
                    </div>
                    <hr>
                    <div class="text-start small">
                        <p class="mb-1"><strong>Struktur Kode:</strong></p>
                        <ul class="mb-0">
                            <li><code>{{ substr($pet->registration_code, 0, 4) }}</code> = Waktu Registrasi ({{ substr($pet->registration_code, 0, 2) }}:{{ substr($pet->registration_code, 2, 2) }})</li>
                            <li><code>{{ substr($pet->registration_code, 4, 4) }}</code> = ID Pemilik ({{ (int)substr($pet->registration_code, 4, 4) }})</li>
                            <li><code>{{ substr($pet->registration_code, 8, 4) }}</code> = Nomor Urut ({{ (int)substr($pet->registration_code, 8, 4) }})</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
