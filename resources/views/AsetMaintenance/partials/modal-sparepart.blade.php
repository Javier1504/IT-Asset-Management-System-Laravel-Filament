<!-- Modal Pilih Sparepart -->
<div class="modal fade" id="assetModal" tabindex="-1" aria-labelledby="assetModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <div class="d-flex gap-2 align-items-center">
                    <div class="ratio ratio-1x1" style="width: 42px; min-width: 42px;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle p-2 border">
                            <i class="sym sym-shopping-bag-solid"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="m-0">Pilih Sparepart</h5>
                        <span class="fs-6 text-secondary">
                            Pilih sparepart yang akan digunakan dalam pemeliharaan
                        </span>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="sparepartSearch" 
                                placeholder="Cari berdasarkan nama atau jenis sparepart...">
                            <button class="btn btn-primary" type="button" id="btnSearchSparepart">
                                <i class="sym sym-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="sparepartPerPage">
                            <option value="10" selected>10 per halaman</option>
                            <option value="25">25 per halaman</option>
                            <option value="50">50 per halaman</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel Sparepart -->
                <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 80px;">Aksi</th>
                                <th>Jenis Sparepart</th>
                                <th>Nama Sparepart</th>
                                <th style="width: 100px;">Qty</th>
                            </tr>
                        </thead>

                        <tbody id="sparepartTableBody">
                            @forelse ($sparepartItems as $sparepart)
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm pilihAset"
                                            data-jenis="{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}"
                                            data-merk="{{ $sparepart->nama_sparepart ?? '-' }}"
                                            data-sparepart-id="{{ $sparepart->id }}">
                                            Pilih
                                        </button>
                                    </td>

                                    <td>{{ $sparepart->jenisSparepart->jenis_sparepart ?? '-' }}</td>
                                    <td>{{ $sparepart->nama_sparepart ?? '-' }}</td>
                                    <td>{{ ($sparepart->qty_masuk ?? 0) - ($sparepart->qty_keluar ?? 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data sparepart yang tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <span class="text-muted" id="sparepartInfo">Menampilkan data sparepart</span>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="sparepartPagination">
                        </ul>
                    </nav>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // Sparepart search and pagination
    let currentPage = 1;
    let currentSearch = '';
    let currentPerPage = 10;

    function loadSparepartItems(page = 1, search = '', perPage = 10) {
        currentPage = page;
        currentSearch = search;
        currentPerPage = perPage;

        fetch(`{{ route('aset-maintenance.get-sparepart-items') }}?page=${page}&search=${encodeURIComponent(search)}&perPage=${perPage}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            updateSparepartTable(data.data);
            updatePagination(data);
            updateInfo(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('sparepartTableBody').innerHTML = 
                '<tr><td colspan="4" class="text-center text-danger">Terjadi kesalahan saat memuat data</td></tr>';
        });
    }

    function updateSparepartTable(items) {
        const tbody = document.getElementById('sparepartTableBody');
        
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Tidak ada data sparepart yang tersedia</td></tr>';
            return;
        }

        tbody.innerHTML = items.map(item => {
            const qtyMasuk = item.qty_masuk || 0;
            const qtyKeluar = item.qty_keluar || 0;
            const qtyTersedia = qtyMasuk - qtyKeluar;
            const jenisSparepart = item.jenis_sparepart?.jenis_sparepart || '-';
            
            return `
                <tr>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm pilihAset"
                            data-jenis="${jenisSparepart}"
                            data-merk="${item.nama_sparepart || '-'}"
                            data-sparepart-id="${item.id}">
                            Pilih
                        </button>
                    </td>
                    <td>${jenisSparepart}</td>
                    <td>${item.nama_sparepart || '-'}</td>
                    <td>${qtyTersedia}</td>
                </tr>
            `;
        }).join('');

        // Re-attach event listeners for new pilihAset buttons
        attachSelectSparepartListeners();
    }

    function updatePagination(data) {
        const pagination = document.getElementById('sparepartPagination');
        let html = '';

        // Previous button
        html += `
            <li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadSparepartItems(${data.current_page - 1}, currentSearch, currentPerPage); return false;">&laquo;</a>
            </li>
        `;

        // Page numbers
        for (let i = 1; i <= data.last_page; i++) {
            if (i === 1 || i === data.last_page || (i >= data.current_page - 1 && i <= data.current_page + 1)) {
                html += `
                    <li class="page-item ${i === data.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadSparepartItems(${i}, currentSearch, currentPerPage); return false;">${i}</a>
                    </li>
                `;
            } else if (i === data.current_page - 2 || i === data.current_page + 2) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Next button
        html += `
            <li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadSparepartItems(${data.current_page + 1}, currentSearch, currentPerPage); return false;">&raquo;</a>
            </li>
        `;

        pagination.innerHTML = html;
    }

    function updateInfo(data) {
        const info = document.getElementById('sparepartInfo');
        if (data.total > 0) {
            info.textContent = `Menampilkan ${data.from} - ${data.to} dari ${data.total} data`;
        } else {
            info.textContent = 'Tidak ada data';
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Search button
        document.getElementById('btnSearchSparepart')?.addEventListener('click', function() {
            const search = document.getElementById('sparepartSearch').value;
            loadSparepartItems(1, search, currentPerPage);
        });

        // Search on Enter key
        document.getElementById('sparepartSearch')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const search = this.value;
                loadSparepartItems(1, search, currentPerPage);
            }
        });

        // Per page change
        document.getElementById('sparepartPerPage')?.addEventListener('change', function() {
            loadSparepartItems(1, currentSearch, parseInt(this.value));
        });
    });
</script>
