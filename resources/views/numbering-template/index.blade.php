@extends('layouts.admin')

@section('title', 'Template Penomoran')

@section('content')
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Pengaturan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Template Penomoran</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form action="" id="categories">
                            <div>
                                <h4 class="m-0">Data Template Penomoran Dokumen</h4>
                            </div>
                        </form>
                        <hr>
                        <div class="row d-flex align-items-center justify-content-between gap-2">

                            <div class="col-md-3">
                                <form>
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('numbering-template.create') }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"
                                    aria-label="Tambah Data">
                                    <i class="sym sym-plus"></i> Tambah
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle">
                                    <tr class="table-light">
                                        <th style="min-width: 36px; width: 36px;">No</th>
                                        <th style="min-width: 120px;">Module</th>
                                        <th style="min-width: 150px;">Perusahaan</th>
                                        <th style="min-width: 180px;">No. Template</th>
                                        <th style="min-width: 180px;">No. SOP</th>
                                        <th style="min-width: 120px;">Versi</th>
                                        <th style="min-width: 120px;">Tipe Nomor</th>
                                        <th style="min-width: 200px;">Format</th>
                                        <th style="min-width: 100px;">Reset</th>
                                        <th class="text-center" style="min-width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($numberingTemplates as $data)
                                        <tr>
                                            <td>{{ ($numberingTemplates->currentPage() - 1) * $numberingTemplates->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ strtoupper($data->module) }}</span>
                                            </td>
                                            <td>
                                                {{ $data->company->name ?? '-' }}
                                                <br>
                                                <small class="text-muted">{{ $data->company->code ?? '-' }}</small>
                                            </td>
                                            <td>{{ $data->no_template }}</td>
                                            <td>{{ $data->no_sop }}</td>
                                            <td>{{ $data->no_version }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">{{ $data->type_number }}</span>
                                            </td>
                                            <td><code>{{ $data->format }}</code></td>
                                            <td>
                                                @if ($data->reset_type == 'yearly')
                                                    <span class="badge bg-success">Tahunan</span>
                                                @elseif ($data->reset_type == 'monthly')
                                                    <span class="badge bg-warning text-dark">Bulanan</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Reset</span>
                                                @endif
                                            </td>
                                            <td style="width: 124px;">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a href="{{ route('numbering-template.edit', $data->id) }}">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-outline-secondary"
                                                            aria-label="Edit" title="Edit">
                                                            <i class="sym sym-edit-solid"></i>
                                                        </button>
                                                    </a>
                                                    <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                                        aria-label="Hapus" title="Hapus"
                                                        onclick="confirmDeletion({{ $data->id }})">
                                                        <i class="sym sym-trash-solid"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $data->id }}"
                                                        action="{{ route('numbering-template.destroy', $data->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center gap-2">
                                                    <i class="sym sym-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                                    <p class="mb-0 text-muted">Tidak ada data template penomoran</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Menampilkan {{ $numberingTemplates->firstItem() ?? 0 }} sampai
                                {{ $numberingTemplates->lastItem() ?? 0 }} dari {{ $numberingTemplates->total() }} data
                            </div>
                            <div>
                                {{ $numberingTemplates->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [END] Content -->
    </main>
    <!-- [END] Main -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: '{!! session('error') !!}',
            });
        @endif
    </script>

    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3 shadow',
                    confirmButton: 'btn btn-primary mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form untuk menghapus data
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
