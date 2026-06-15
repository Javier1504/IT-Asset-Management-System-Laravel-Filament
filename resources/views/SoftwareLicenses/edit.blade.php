@extends('layouts.admin')

@section('title', 'Edit License Software')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Edit License Software</h4>
            <p class="text-muted mb-0">
                Perbarui data license software: {{ $softwareLicense->software_name }}.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('software-licenses.show', $softwareLicense->id) }}" class="btn btn-outline-primary">
                Detail
            </a>

            <a href="{{ route('software-licenses.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Data belum valid.</strong> Periksa kembali input yang ditandai.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('software-licenses.update', $softwareLicense->id) }}">
                @method('PUT')

                @include('SoftwareLicenses._form', [
                    'softwareLicense' => $softwareLicense,
                    'submitLabel' => 'Update License'
                ])
            </form>
        </div>
    </div>
</div>
@endsection