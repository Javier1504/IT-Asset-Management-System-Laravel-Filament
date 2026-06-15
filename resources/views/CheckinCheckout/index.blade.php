@extends('layouts.admin')
@section('title', 'Checkin Checkout Sparepart')
@section('content')
    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Sparepart</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('jenis-sparepart.index') }}">Jenis
                                        Sparepart</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('sparepart-item.index', ['jenis_sparepart_id' => $jenisSparepart->id]) }}">
                                        Sparepart Item</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Keluar Masuk Sparepart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="col-md-6">
                                <h5 class="card-title mb-1">
                                    Data Keluar Masuk Sparepart - {{ $sparepartItem->nama_sparepart }}
                                </h5>
                                <span class="text-muted">Daftar data keluar masuk sparepart</span>
                            </div>
                            <div class="col d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('checkin-checkout-spareparts.export-excel', ['sparepart_id' => $sparepartItem->id, 'tab' => $tab, 'search' => request('search')]) }}"
                                    class="btn btn-success d-flex align-items-center gap-1"
                                    aria-label="Export Excel">
                                    <i class="sym sym-file-download-02"></i> Export Excel
                                </a>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="sym sym-plus"></i> Tambah Data
                                </button>
                            </div>
                        </div>

                        {{-- SEARCH FORM --}}
                        <form method="GET" action="{{ route('checkin-checkout-spareparts.index', $sparepartItem->id) }}"
                            class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari berdasarkan tipe, keterangan, pemegang, atau nomor aset..."
                                    value="{{ request('search') }}">
                                <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                <input type="hidden" name="tab" value="{{ $tab }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="sym sym-search"></i> Cari
                                </button>
                                @if (request('search'))
                                    <a href="{{ route('checkin-checkout-spareparts.index', $sparepartItem->id) }}"
                                        class="btn btn-outline-danger">
                                        <i class="sym sym-x"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </form>

                        {{-- NAV TABS --}}
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab === 'checkin' ? 'active' : '' }}" id="checkin-tab"
                                    data-bs-toggle="tab" data-bs-target="#checkin-tab-pane" type="button" role="tab"
                                    aria-controls="checkin-tab-pane" aria-selected="{{ $tab === 'checkin' }}">
                                    Check In
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $tab === 'checkout' ? 'active' : '' }}" id="checkout-tab"
                                    data-bs-toggle="tab" data-bs-target="#checkout-tab-pane" type="button" role="tab"
                                    aria-controls="checkout-tab-pane" aria-selected="{{ $tab === 'checkout' }}">
                                    Check Out
                                </button>
                            </li>
                        </ul>

                        {{-- CONTENT TAB --}}
                        <div class="tab-content" id="myTabContent">
                            {{-- TAB CHECKIN --}}
                            <div class="tab-pane fade {{ $tab === 'checkin' ? 'show active' : '' }}" id="checkin-tab-pane"
                                role="tabpanel" aria-labelledby="checkin-tab">
                                @include('CheckinCheckout.partials.checkin-table')
                            </div>

                            {{-- TAB CHECKOUT --}}
                            <div class="tab-pane fade {{ $tab === 'checkout' ? 'show active' : '' }}"
                                id="checkout-tab-pane" role="tabpanel" aria-labelledby="checkout-tab">
                                @include('CheckinCheckout.partials.checkout-table')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- MODAL TAMBAH --}}
    @include('CheckinCheckout.modals.add')

    {{-- MODAL EDIT --}}
    @include('CheckinCheckout.modals.edit')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
            });
        @endif
    </script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'rounded-3 shadow',
                    confirmButton: 'btn btn-danger mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    <script>
        // Simpan tab aktif saat klik tab
        document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(button => {
            button.addEventListener('click', function(event) {
                const tabId = event.target.id.replace('-tab', '');
                updateUrlTab(tabId);
            });
        });

        // Update URL dengan parameter tab
        function updateUrlTab(tab) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }

        // Update items per page
        function updateItemsPerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Edit modal
        function editData(id, tipe, qty, alasan, userId, asetId, tanggal) {
            document.getElementById('edit_tipe').value = tipe;
            document.getElementById('edit_qty').value = qty;
            document.getElementById('edit_alasan').value = alasan;
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_aset_id').value = asetId;
            document.getElementById('edit_tanggal').value = tanggal;

            const form = document.getElementById('editForm');
            form.action = `/checkin-checkout-spareparts/${id}`;

            // Ambil field wrapper
            const alasanField = document.querySelector('.field-edit-alasan');
            const userField = document.querySelector('.field-edit-user');
            const asetField = document.querySelector('.field-edit-aset');

            // Show/hide berdasarkan tipe
            if (tipe === 'checkin') {
                alasanField.style.display = "block";
                userField.style.display = "none";
                asetField.style.display = "none";

                document.getElementById("edit_alasan").required = false;
                document.getElementById("edit_user_id").required = false;
                document.getElementById("edit_aset_id").required = false;

            } else {
                alasanField.style.display = "block";
                userField.style.display = "block";
                asetField.style.display = "block";

                // Add required attributes
                document.getElementById("edit_alasan").required = true;
                document.getElementById("edit_user_id").required = false;
                document.getElementById("edit_aset_id").required = false; // tetap opsional
            }

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tipeSelect = document.getElementById("tipe");

            const fieldAlasan = document.querySelector(".field-alasan");
            const fieldUser = document.querySelector(".field-user");
            const fieldAset = document.querySelector(".field-aset");

            function toggleFields() {
                const tipe = tipeSelect.value;

                if (tipe === "checkin") {
                    // hide these fields
                    fieldAlasan.style.display = "block";
                    fieldUser.style.display = "none";
                    fieldAset.style.display = "none";

                    // remove required attribute
                    document.getElementById("alasan").required = false;
                    document.getElementById("user_id").required = false;
                    document.getElementById("aset_id").required = false;

                } else if (tipe === "checkout") {
                    // show these fields
                    fieldAlasan.style.display = "block";
                    fieldUser.style.display = "block";
                    fieldAset.style.display = "block";

                    // add required attribute
                    document.getElementById("alasan").required = true;
                    document.getElementById("user_id").required = false;
                    document.getElementById("aset_id").required = false;
                }
            }

            tipeSelect.addEventListener("change", toggleFields);

            // initial state
            toggleFields();
        });
    </script>

@endsection
