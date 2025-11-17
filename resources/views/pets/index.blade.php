{{-- resources/views/pets/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Hewan')
@section('header', 'Data Hewan Peliharaan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Hewan</h5>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Hewan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Registrasi</th>
                        <th>Nama Hewan</th>
                        <th>Jenis</th>
                        <th>Usia</th>
                        <th>Berat</th>
                        <th>Pemilik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pets as $pet)
                    <tr>
                        <td>{{ $loop->iteration + ($pets->currentPage() - 1) * $pets->perPage() }}</td>
                        <td>
                            <code class="text-primary">{{ $pet->registration_code }}</code>
                        </td>
                        <td>
                            <strong>{{ $pet->name }}</strong>
                            @if($pet->breed)
                            <br><small class="text-muted">{{ $pet->breed }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ $pet->species }}</span></td>
                        <td>{{ $pet->age }} tahun</td>
                        <td>{{ $pet->weight }} kg</td>
                        <td>
                            <a href="{{ route('owners.show', $pet->owner) }}" class="text-decoration-none">
                                {{ $pet->owner->name }}
                            </a>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pets.show', $pet) }}" class="btn btn-info mx-1 rounded" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning mx-1 rounded" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus"
                                        onclick="return confirm('Yakin ingin menghapus data hewan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada data hewan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $pets->links() }}
        </div>
    </div>
</div>
@endsection
