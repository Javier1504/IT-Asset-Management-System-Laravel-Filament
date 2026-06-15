@extends('layouts.admin')

@section('title', 'Tambah License Software')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Tambah License Software</h4>
            <p class="text-muted mb-0">
                Tambahkan data software internal dan informasi lisensinya.
            </p>
        </div>

        <a href="{{ route('software-licenses.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> Periksa kembali input yang ditandai.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('software-licenses.store') }}">
                @include('SoftwareLicenses._form', [
                    'softwareLicense' => null,
                    'submitLabel' => 'Simpan License'
                ])
            </form>
        </div>
    </div>
</div>
@endsection