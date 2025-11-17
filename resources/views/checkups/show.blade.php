{{-- resources/views/checkups/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')
@section('header', 'Detail Pemeriksaan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard2-pulse-fill"></i> Pemeriksaan - {{ $checkup->pet->name }}
                    </h5>
                    <span class="badge bg-light text-dark">{{ $checkup->checkup_date->format('d F Y') }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-heart-fill"></i> Informasi Hewan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Nama Hewan:</th>
                                        <td>
                                            <a href="{{ route('pets.show', $checkup->pet) }}" class="text-decoration-none">
                                                <strong>{{ $checkup->pet->name }}</strong>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis:</th>
                                        <td><span class="badge bg-info">{{ $checkup->pet->species }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Usia:</th>
                                        <td>{{ $checkup->pet->age }} tahun</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Registrasi:</th>
                                        <td><code>{{ $checkup->pet->registration_code }}</code></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Pemilik:</th>
                                        <td>
                                            <a href="{{ route('owners.show', $checkup->pet->owner) }}" class="text-decoration-none">
                                                {{ $checkup->pet->owner->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Telepon:</th>
                                        <td>{{ $checkup->pet->owner->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat:</th>
                                        <td>{{ Str::limit($checkup->pet->owner->address, 50) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><i class="bi bi-clipboard-data"></i> Detail Pemeriksaan</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Tanggal:</th>
                                <td>
                                    <strong>{{ $checkup->checkup_date->format('d F Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $checkup->checkup_date->diffForHumans() }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Treatment:</th>
                                <td>
                                    <span class="badge bg-primary">{{ $checkup->treatment->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $checkup->treatment->category }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Biaya:</th>
                                <td><strong class="text-success">Rp {{ number_format($checkup->treatment->price, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Berat:</th>
                                <td>
                                    @if($checkup->weight)
                                        <strong>{{ $checkup->weight }} kg</strong>
                                        @if($checkup->pet->weight)
                                            @php
                                                $diff = $checkup->weight - $checkup->pet->weight;
                                            @endphp
                                            @if($diff > 0)
                                                <span class="badge bg-success">+{{ $diff }} kg</span>
                                            @elseif($diff < 0)
                                                <span class="badge bg-danger">{{ $diff }} kg</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="text-muted">Tidak diukur</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Suhu Tubuh:</th>
                                <td>
                                    @if($checkup->temperature)
                                        <strong>{{ $checkup->temperature }}°C</strong>
                                        @if($checkup->temperature > 39.5)
                                            <span class="badge bg-danger">Tinggi</span>
                                        @elseif($checkup->temperature < 37.5)
                                            <span class="badge bg-info">Rendah</span>
                                        @else
                                            <span class="badge bg-success">Normal</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Tidak diukur</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dicatat:</th>
                                <td>
                                    {{ $checkup->created_at->format('d/m/Y H:i') }}
                                    <br>
                                    <small class="text-muted">{{ $checkup->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($checkup->diagnosis)
                <div class="mb-3">
                    <h6><i class="bi bi-prescription2"></i> Diagnosis</h6>
                    <div class="alert alert-info">
                        {{ $checkup->diagnosis }}
                    </div>
                </div>
                @endif

                @if($checkup->notes)
                <div class="mb-3">
                    <h6><i class="bi bi-journal-text"></i> Catatan Tambahan</h6>
                    <div class="alert alert-secondary">
                        {{ $checkup->notes }}
                    </div>
                </div>
                @endif

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('checkups.edit', $checkup) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('checkups.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('checkups.destroy', $checkup) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus data pemeriksaan ini?')">
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
                <h6 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Pemeriksaan Lain</h6>
            </div>
            <div class="card-body">
                @forelse($otherCheckups as $other)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">{{ $other->checkup_date->format('d/m/Y') }}</small>
                        <span class="badge bg-primary badge-sm">{{ $other->treatment->name }}</span>
                    </div>
                    @if($other->diagnosis)
                    <p class="small mb-1 mt-1">{{ Str::limit($other->diagnosis, 60) }}</p>
                    @endif
                    <a href="{{ route('checkups.show', $other) }}" class="btn btn-sm btn-outline-info">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @empty
                <p class="text-center text-muted py-3 mb-0">
                    <i class="bi bi-inbox"></i><br>
                    Tidak ada riwayat lain
                </p>
                @endforelse

                <a href="{{ route('pets.show', $checkup->pet) }}" class="btn btn-sm btn-primary w-100 mt-3">
                    <i class="bi bi-list"></i> Lihat Semua Riwayat
                </a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Info Treatment</h6>
            </div>
            <div class="card-body">
                <h6>{{ $checkup->treatment->name }}</h6>
                <p class="small mb-2"><strong>Kategori:</strong> {{ $checkup->treatment->category }}</p>
                @if($checkup->treatment->description)
                <p class="small mb-2"><strong>Deskripsi:</strong></p>
                <p class="small text-muted">{{ $checkup->treatment->description }}</p>
                @endif
                <div class="alert alert-success mb-0">
                    <strong>Biaya:</strong> Rp {{ number_format($checkup->treatment->price, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('checkups.create') }}?pet_id={{ $checkup->pet_id }}" class="btn btn-sm btn-success w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Pemeriksaan Baru untuk {{ $checkup->pet->name }}
                </a>
                <a href="{{ route('pets.show', $checkup->pet) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-eye"></i> Lihat Detail Hewan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
