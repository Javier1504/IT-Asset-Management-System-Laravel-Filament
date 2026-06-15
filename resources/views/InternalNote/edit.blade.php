@extends('layouts.admin')

@section('title', 'Edit Catatan Internal Tim')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Edit Catatan Internal Tim</h4>
        <p class="text-muted mb-0">
            Perbarui catatan, prioritas, status, jadwal, atau tindak lanjut.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('internal-notes.update', $note) }}" method="POST">
                @csrf
                @method('PUT')

                @include('InternalNote.form', [
                    'note' => $note,
                    'buttonText' => 'Update Catatan'
                ])
            </form>
        </div>
    </div>
</div>
@endsection
