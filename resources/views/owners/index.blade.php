@extends('layouts.app')

@section('title', 'Data Pemilik')
@section('header', 'Data Pemilik Hewan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pemilik</h5>
        <a href="{{ route('owners.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pemilik
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Jumlah Hewan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                    <tr>
                        <td>{{ $loop->iteration + ($owners->currentPage() - 1) * $owners->perPage() }}</td>
                        <td><strong>{{ $owner->name }}</strong></td>
                        <td><i class="bi bi-telephone"></i> {{ $owner->phone }}</td>
                        <td>{{ $owner->email ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $owner->pets_count }} hewan</span></td>
                        <td>
                            <a href="{{ route('owners.show', $owner) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('owners.destroy', $owner) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada data pemilik
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $owners->links() }}
        </div>
    </div>
</div>
@endsection
