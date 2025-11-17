{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - Klinik Hewan')
@section('header', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Pemilik</h6>
                        <h2 class="mb-0">{{ $totalOwners }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Hewan</h6>
                        <h2 class="mb-0">{{ $totalPets }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="bi bi-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Pemeriksaan</h6>
                        <h2 class="mb-0">{{ $totalCheckups }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Jenis Perawatan</h6>
                        <h2 class="mb-0">{{ $totalTreatments }}</h2>
                    </div>
                    <div class="fs-1">
                        <i class="bi bi-prescription2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Checkups -->
    <div class="col-md-7 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Pemeriksaan Terakhir</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Hewan</th>
                                <th>Pemilik</th>
                                <th>Perawatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCheckups as $checkup)
                            <tr>
                                <td>{{ $checkup->checkup_date->format('d/m/Y') }}</td>
                                <td>{{ $checkup->pet->name }}</td>
                                <td>{{ $checkup->pet->owner->name }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $checkup->treatment->name }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada data pemeriksaan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($recentCheckups->count() > 0)
            <div class="card-footer bg-white text-center">
                <a href="{{ route('checkups.index') }}" class="text-decoration-none">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Popular Treatments -->
    <div class="col-md-5 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-star"></i> Perawatan Terpopuler</h5>
            </div>
            <div class="card-body">
                @forelse($popularTreatments as $treatment)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ $treatment->name }}</h6>
                        <small class="text-muted">{{ $treatment->category }}</small>
                    </div>
                    <div>
                        <span class="badge bg-success">{{ $treatment->checkups_count }} kali</span>
                    </div>
                </div>
                @if(!$loop->last)
                <hr>
                @endif
                @empty
                <p class="text-center text-muted py-4 mb-0">
                    Belum ada data perawatan
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('owners.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Tambah Pemilik
                    </a>
                    <a href="{{ route('pets.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Hewan
                    </a>
                    <a href="{{ route('checkups.create') }}" class="btn btn-info text-white">
                        <i class="bi bi-clipboard-plus"></i> Tambah Pemeriksaan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
