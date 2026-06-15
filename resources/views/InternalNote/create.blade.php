@extends('layouts.admin')

@section('title', 'Tambah Catatan Internal Tim')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Tambah Catatan Internal Tim</h4>
        <p class="text-muted mb-0">
            Buat catatan operasional, pembelian, insiden, penerimaan perangkat, konfigurasi, atau routing.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('internal-notes.store') }}" method="POST">
                @csrf

                @include('InternalNote.form', [
                    'note' => null,
                    'buttonText' => 'Simpan Catatan',
                    'prefill' => $prefill ?? []
                ])
            </form>
        </div>
    </div>
</div>
@endsection
