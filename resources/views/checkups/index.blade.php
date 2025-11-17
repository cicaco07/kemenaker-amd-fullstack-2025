@extends('layouts.app')

@section('title', 'Data Pemeriksaan')
@section('header', 'Data Pemeriksaan Hewan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clipboard2-pulse"></i> Daftar Pemeriksaan</h5>
        <a href="{{ route('checkups.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pemeriksaan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hewan</th>
                        <th>Pemilik</th>
                        <th>Treatment</th>
                        <th>Diagnosis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkups as $checkup)
                    <tr>
                        <td>{{ $loop->iteration + ($checkups->currentPage() - 1) * $checkups->perPage() }}</td>
                        <td>
                            <strong>{{ $checkup->checkup_date->format('d/m/Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $checkup->checkup_date->diffForHumans() }}</small>
                        </td>
                        <td>
                            <a href="{{ route('pets.show', $checkup->pet) }}" class="text-decoration-none">
                                <strong>{{ $checkup->pet->name }}</strong>
                            </a>
                            <br>
                            <small class="text-muted">{{ $checkup->pet->species }}</small>
                        </td>
                        <td>
                            <a href="{{ route('owners.show', $checkup->pet->owner) }}" class="text-decoration-none">
                                {{ $checkup->pet->owner->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $checkup->pet->owner->phone }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $checkup->treatment->name }}</span>
                            <br>
                            <small class="text-muted">{{ $checkup->treatment->type }}</small>
                        </td>
                        <td>
                            @if($checkup->diagnosis)
                                {{ Str::limit($checkup->diagnosis, 30) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('checkups.show', $checkup) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('checkups.edit', $checkup) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('checkups.destroy', $checkup) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus"
                                        onclick="return confirm('Yakin ingin menghapus data pemeriksaan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data pemeriksaan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $checkups->links() }}
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">{{ $checkups->total() }}</h3>
                <p class="text-muted mb-0">Total Pemeriksaan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ \App\Models\Checkup::whereDate('checkup_date', today())->count() }}</h3>
                <p class="text-muted mb-0">Pemeriksaan Hari Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ \App\Models\Checkup::whereBetween('checkup_date', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</h3>
                <p class="text-muted mb-0">Minggu Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ \App\Models\Checkup::whereMonth('checkup_date', now()->month)->count() }}</h3>
                <p class="text-muted mb-0">Bulan Ini</p>
            </div>
        </div>
    </div>
</div>
@endsection
