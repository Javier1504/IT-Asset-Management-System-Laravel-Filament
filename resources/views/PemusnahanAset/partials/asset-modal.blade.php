<div class="modal fade" id="assetModal" tabindex="-1" aria-labelledby="assetModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex gap-2 align-items-center">
                    <div class="ratio ratio-1x1" style="width: 42px; min-width: 42px;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                            <i class="sym sym-shopping-bag-solid"></i>
                        </span>
                    </div>
                    <div class="d-block ms-1">
                        <h5 class="m-0">Jenis Aset Yang Akan Dimusnahkan</h5>
                        <p class="m-0 text-secondary fs-6">
                            Pilih jenis aset yang akan dimusnahkan dari daftar berikut.
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="assetTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="aset-tab" data-bs-toggle="tab" href="#aset" role="tab"
                            aria-controls="aset" aria-selected="true">Aset</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="sparepart-tab" data-bs-toggle="tab" href="#sparepart" role="tab"
                            aria-controls="sparepart" aria-selected="false">Sparepart</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="assetTabContent">
                    {{-- Tab End-User Aset --}}
                    <div class="tab-pane fade show active" id="aset" role="tabpanel">
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-3">
                            <div class="col-12">
                                <div class="row g-2">
                                    {{-- Filter Kategori --}}
                                    <div class="col-md-4">
                                        <select class="form-select" id="filterJenis" name="jenis_aset">
                                            <option value="">Jenis Aset</option>
                                            @foreach ($jenisAsets ?? [] as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->name_jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Pencarian --}}
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="search" id="searchInput"
                                            placeholder="Cari nomor aset, merk, atau spesifikasi..." autocomplete="off">
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" id="btnSearch" class="btn btn-primary w-100">
                                            <i class="sym sym-search me-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3" id="asetTable"
                            style="max-height:400px; overflow-y:auto; display:block;">
                            <table class="table table-bordered align-middle">
                                <thead class="align-middle"
                                    style="position:sticky; top:0; background:#fff; z-index:10;">
                                    <tr class="table-light">
                                        <th class="text-center">Aksi</th>
                                        <th style="min-width: 140px;">
                                            <button class="btn p-0 border-0 w-100 text-start sortable"
                                                data-sort="nomor_aset">
                                                Nomor Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 140px;">
                                            <button class="btn p-0 border-0 w-100 text-start sortable"
                                                data-sort="jenis_aset">
                                                Jenis Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 200px;">
                                            <button class="btn p-0 border-0 w-100 text-start sortable"
                                                data-sort="merk_aset">
                                                Merk Aset
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 300px;">Spesifikasi Aset</th>
                                        <th style="min-width: 140px;">Klasifikasi Aset</th>
                                        <th style="min-width: 140px;">
                                            <button class="btn p-0 border-0 w-100 text-start sortable"
                                                data-sort="tanggal_pembelian">
                                                Tanggal Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                        <th style="min-width: 150px;">
                                            <button class="btn p-0 border-0 w-100 text-start sortable"
                                                data-sort="harga_pembelian">
                                                Harga Beli
                                                <i class="float-end sym sym-switch-vertical"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="asetTableBody">
                                    @forelse ($asets ?? [] as $aset)
                                        <tr>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-sm pilihAset"
                                                    data-nomor="{{ $aset->nomor_aset ?? '-' }}"
                                                    data-jenis="{{ $aset->jenisAset->name_jenis ?? '-' }}"
                                                    data-merk="{{ $aset->merk_aset ?? '-' }}"
                                                    data-aset-id="{{ $aset->id }}">
                                                    Pilih
                                                </button>
                                            </td>
                                            <td>{{ $aset->nomor_aset ?? '-' }}</td>
                                            <td>{{ $aset->jenisAset->name_jenis ?? '-' }}</td>
                                            <td>{{ $aset->merk_aset ?? '-' }}</td>
                                            <td>{{ $aset->spesifikasi_aset ?? '-' }}</td>
                                            <td>{{ $aset->endUserAsets->first()->klasifikasiLaptop->klasifikasi_laptop ?? '-' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}
                                            </td>
                                            <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data aset yang tersedia
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                {{-- <small class="text-muted">
                                        Menampilkan <span id="showingFrom">1</span> - <span id="showingTo">10</span>
                                        dari <span id="totalRecords">{{ $asets->total() ?? 0 }}</span> data
                                    </small> --}}
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="paginationLinks">
                                    {{-- {{ $asets->links() ?? '' }} --}}
                                </ul>
                            </nav>
                        </div>
                    </div>

                    {{-- Tab Sparepart --}}
                    <div class="tab-pane fade" id="sparepart" role="tabpanel" aria-labelledby="sparepart-tab">
                        <div class="row d-flex align-items-center justify-content-between gap-2 mb-3">
                            <div class="col-12">
                                <div class="row g-2">
                                    {{-- Pencarian Sparepart --}}
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="searchSparepart"
                                            placeholder="Cari jenis atau nama sparepart..." autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="btnSearchSparepart" class="btn btn-primary w-100">
                                            <i class="sym sym-search me-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3" style="max-height:400px; overflow-y:auto; display:block;">
                            <table class="table table-bordered align-middle">
                                <thead style="position:sticky; top:0; background:#fff; z-index:10;">
                                    <tr class="table-light">
                                        <th>Aksi</th>
                                        <th>Jenis Sparepart</th>
                                        <th>Nama Sparepart</th>
                                        <th>Jumlah Sparepart</th>
                                    </tr>
                                </thead>
                                <tbody id="sparepartTableBody">
                                    @forelse ($sparepartItems ?? [] as $sparepart)
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary btn-sm pilihAset"
                                                    data-jenis="{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}"
                                                    data-merk="{{ $sparepart->nama_sparepart ?? '-' }}"
                                                    data-sparepart-id="{{ $sparepart->id }}">
                                                    Pilih
                                                </button>
                                            </td>
                                            <td>{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}</td>
                                            <td>{{ $sparepart->nama_sparepart ?? '-' }}</td>
                                            <td>{{ $sparepart->jumlah_sparepart ?? '0' }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data sparepart yang
                                                tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Sparepart --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Menampilkan data sparepart
                                </small>
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="paginationLinksSparepart">
                                    {{-- {{ $sparepartItems->links() ?? '' }} --}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
