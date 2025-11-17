@extends('layouts.app')

@section('title', 'Detail Pemilik')
@section('header', 'Detail Pemilik')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> {{ $owner->name }}</h5>
                <span class="badge bg-light text-dark">ID: {{ $owner->id }}</span>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama:</th>
                        <td><strong>{{ $owner->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Telepon:</th>
                        <td><i class="bi bi-telephone"></i> {{ $owner->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $owner->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat:</th>
                        <td>{{ $owner->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar:</th>
                        <td>{{ $owner->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('owners.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
