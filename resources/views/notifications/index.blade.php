@extends('layouts.admin')

@section('title', 'Notifikasi')
<style>
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">

                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-bell"></i> Notifikasi</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Riwayat Notifikasi
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('notifications.destroy-all') }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi? Tindakan ini tidak dapat dibatalkan.')">
                                Hapus Semua Notifikasi
                            </button>
                        </form>
                        <form method="POST" action="{{ route('notifications.mark-all-as-read') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                Tandai Semua Dibaca
                            </button>
                        </form>
                    </div>

                </div>


                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        @forelse ($notifications as $notif)
                            <div
                                class="card mb-3 shadow-sm {{ !$notif->is_read ? 'border-start border-primary border-4' : '' }}">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div
                                                class="avatar-circle {{ !$notif->is_read ? 'bg-primary' : 'bg-secondary' }}">
                                                <i class="fas fa-bell text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">
                                                        @if ($notif->url)
                                                            <a href="{{ $notif->url }}" class="text-decoration-none">
                                                                {{ $notif->title }}
                                                            </a>
                                                        @else
                                                            {{ $notif->title }}
                                                        @endif
                                                        @if (!$notif->is_read)
                                                            <span class="badge bg-primary ms-2">Baru</span>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-2 text-muted">{{ $notif->message }}</p>
                                                    <small class="text-muted">
                                                        <i
                                                            class="far fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('notifications.destroy', $notif->id) }}"
                                                    class="ms-3">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus notifikasi ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Anda akan menerima notifikasi disini</p>
                            </div>
                        @endforelse

                        @if (method_exists($notifications, 'links') && $notifications->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Menampilkan {{ $notifications->firstItem() ?? 0 }} sampai
                                    {{ $notifications->lastItem() ?? 0 }}
                                    dari {{ $notifications->total() }} notifikasi
                                </div>
                                <div class="pagination-wrapper">
                                    {{ $notifications->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @elseif (method_exists($notifications, 'count') && $notifications->count() > 0)
                            <div class="text-center text-muted mt-3">
                                <small>{{ $notifications->count() }} notifikasi ditampilkan</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
