@extends('layouts.admin')

@section('title', 'Page All Network Aset')

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
                  <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Aset</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Network Aset</li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
              <h4 class="m-0">Data Network Aset</h4>
              <div class="row mt-4">
                <form action="{{ route('network-aset.index') }}" method="GET" id="filterForm">
                    <!-- Filter berdasarkan status aset -->
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subcategories[]" value="stock" id="stock" @if(in_array('stock', request('subcategories', []))) checked @endif>
                                <label class="form-check-label" for="stock">Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subcategories[]" value="terpakai" id="terpakai" @if(in_array('terpakai', request('subcategories', []))) checked @endif>
                                <label class="form-check-label" for="terpakai">Terpakai</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subcategories[]" value="disewakan" id="disewakan" @if(in_array('disewakan', request('subcategories', []))) checked @endif>
                                <label class="form-check-label" for="disewakan">Disewakan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subcategories[]" value="retirement" id="retirement" @if(in_array('retirement', request('subcategories', []))) checked @endif>
                                <label class="form-check-label" for="retirement">Retirement</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
                <hr>
              <div class="row d-flex align-items-center justify-content-between gap-2">
                <div class="col-md-3">
                  <form>
                      <div class="row g-2">
                          <div class="col">
                              <input type="text" class="form-control" name="nomor_aset"
                                  placeholder="Cari Nomor Aset.." value="{{ request('nomor_aset') }}" autocomplete="off">
                          </div>
                          <div class="col-auto">
                              <button type="submit" class="btn btn-primary">Cari</button>
                          </div>
                      </div>
                  </form>
              </div>
              
                <div class="col d-flex justify-content-end align-items-center gap-2">
                  <div class="col-md-3">
                    <form method="GET" action="{{ route('network-aset.index') }}">
                      <select class="form-select" id="jenis_aset_id" name="jenis_aset_id" onchange="this.form.submit()"
                        aria-label="Default select example">
                        <option value="" {{ request('jenis_aset_id')=='' ? 'selected' : '' }}>Semua Jenis</option>
                        @foreach($jenisAsets as $jenis)
                        @if ($jenis->jenisAset)
                        <!-- Check if jenisAset exists -->
                        <option value="{{ $jenis->jenisAset->id }}" {{ request('jenis_aset_id')==$jenis->jenisAset->id ?
                          'selected' : '' }}>
                          {{ $jenis->jenisAset->name_jenis ?? '' }}
                        </option>
                        @endif
                        @endforeach
                      </select>
                    </form>                    
                  </div>
                           
              
                  {{-- Tombol tambah data --}}
                  <div class="d-flex align-items-center">
                    <a href="{{ route('network-aset.create') }}" class="btn btn-primary d-block" aria-label="Tambah Data">
                          <i class="sym sym-plus"></i> Tambah
                      </a>
                  </div>
              </div>
              
              </div>                  
                <div class="table-responsive mt-4">
                  <table class="table table-bordered align-middle">
                    <thead class="align-middle">
                      <tr class="table-light">
                        <th style="min-width: 36px; width: 36px;" rowspan="2">No</th>
                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Nomor Aset
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Nama Perangkat
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                            <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                              Mac Address Perangkat
                              <i class="float-end sym sym-switch-vertical"></i>
                            </button>
                        </th>
                        <th style="min-width: 160px; width: 10%;" rowspan="2">
                            <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                              Lokasi
                              <i class="float-end sym sym-switch-vertical"></i>
                            </button>
                        </th>
                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                            <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                              Jenis Aset
                              <i class="float-end sym sym-switch-vertical"></i>
                            </button>
                        </th>
                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                            <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                              Heirarchi Perangkat
                              <i class="float-end sym sym-switch-vertical"></i>
                            </button>
                        </th>
                        <th style="min-width: 200px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Merk Aset
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th style="min-width: 300px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Spesifikasi Aset
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>   
                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Tanggal Beli
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th style="min-width: 150px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Harga Beli
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th style="min-width: 140px; width: 10%;" rowspan="2">
                          <button class="btn p-0 border-0 w-100 h-100 text-start"aria-label="Photo: active to sort">
                            Status
                            <i class="float-end sym sym-switch-vertical"></i>
                          </button>
                        </th>
                        <th class="text-center" rowspan="2">Aksi</th>
                        @php
                        $totalYears = $yearInit['endYear'] - $yearInit['earlyYear'] + 1;
                        $colspan = 1 + 1 + ($totalYears * 2) + 1;
                        @endphp
                          <th colspan="{{ $colspan }}" class="text-center" style="min-width: 140px; width: 10%;">
                            <span>Nilai Penyusutan Aset</span>
                            <button class="btn btn-sm btn-outline-secondary ms-2 toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target=".collapse-depreciation">
                                <!-- Ikon akan dimasukkan lewat script -->
                            </button>                        
                        </th>                      
                      </tr>
                      <tr class="table-light">
                        <th class="collapse collapse-depreciation text-center" style="min-width: 140px; width: 10%;">Harga/Bulan</th>
                        <th class="collapse collapse-depreciation text-center" style="min-width: 100px; width: 10%;">Cut Off</th>
                        <th class="collapse collapse-depreciation text-center" style="min-width: 100px; width: 10%;">Masa Umur</th>
                        @for ($year = $yearInit['earlyYear']; $year <= $yearInit['endYear']; $year++)
                            <th class="collapse collapse-depreciation text-center" style="min-width: 140px; width: 10%;">{{ $year }}</th>
                            <th class="collapse collapse-depreciation text-center" style="min-width: 140px; width: 10%;">Nilai Sisa</th>
                        @endfor
                        <th class="collapse collapse-depreciation text-center" style="min-width: 140px; width: 10%;">Total Penyusutan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($networkAsets as $aset)
                      <tr>
                          <td>{{ ($networkAsets->currentPage() - 1) * $networkAsets->perPage() + $loop->iteration }}</td>
                          <td>{{ $aset->nomor_aset ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ $aset->nama_perangkat ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ $aset->mac_address_perangkat ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ $aset->lokasi ?? '-' }}</td>
                          <td>{{ $aset->jenis_aset ?? '-' }}</td>
                          <td>{{ $aset->heirarchi_perangkat ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ $aset->merk_aset ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ $aset->spesifikasi_aset ?? '-' }}</td> <!-- Make sure to access through aset relationship -->
                          <td>{{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('d/m/Y') }}</td>
                          <td>Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }} </td>
                          <td style="text-align: center;">
                              @if ($aset->status_aset == 'stock')
                                  <span class="badge text-primary bg-primary bg-opacity-10 border border-primary">Stock</span>
                              @elseif ($aset->status_aset == 'terpakai')
                                  <span class="badge text-success bg-success bg-opacity-10 border border-success">Terpakai</span>
                              @elseif ($aset->status_aset == 'disewakan')
                                  <span class="badge text-info bg-info bg-opacity-10 border border-info">Disewakan</span>
                              @elseif ($aset->status_aset == 'retirement')
                                  <span class="badge text-danger bg-danger bg-opacity-10 border border-danger">Retirement</span>
                              @else
                                  <span>{{ $aset->status_aset }}</span>
                              @endif
                          </td>
                          
                          <td style="width: 124px;">
                            <div class="d-flex align-items-center justify-content-end gap-1">
                              <a href="{{ route('network-aset.show', $aset->id) }}" class="d-none d-md-block btn btn-icon btn-sm btn-outline-secondary" aria-label="Lihat detail" title="Lihat detail">
                                <i class="sym sym-eye-solid"></i>
                              </a>
                              <a href="{{ route('network-aset.edit', $aset->id) }}">
                                <button type="button" class="d-none d-md-block btn btn-icon btn-sm btn-outline-secondary" aria-label="Edit" title="Edit">
                                    <i class="sym sym-edit-solid"></i>
                                </button>
                              </a> 
                           
                            <button 
                                type="button" 
                                class="btn btn-icon btn-sm btn-outline-secondary" 
                                aria-label="Hapus"
                                title="Hapus"
                                onclick="confirmDeletion({{ $aset->id }})">
                                <i class="sym sym-trash-solid"></i>
                            </button>
                    
                            <form 
                                id="delete-form-{{ $aset->id }}" 
                                action="{{ route('network-aset.destroy', $aset->id) }}" 
                                method="POST" 
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                          </td>
                          <!-- Kolom Nilai Penyusutan -->
                      <td class="collapse collapse-depreciation">Rp {{ number_format((float) $aset->harga_per_bulan, 0, ',', '.') }}</td>
                      <td class="collapse collapse-depreciation">{{ $aset->cut_off }}</td>
                      <td class="collapse collapse-depreciation">{{ $aset->masa_umur }}</td>
                      
                      @php 
                          $depreciationValues = collect($aset->depreciation_data)->pad($totalYears * 2, '-'); 
                      @endphp
          
                      @foreach($depreciationValues as $values)
                          <td class="collapse collapse-depreciation">{{ $values !== '-' ? "Rp " . number_format((float) $values, 0, ',', '.') : $values }}</td>
                      @endforeach
          
                      <td class="collapse collapse-depreciation">Rp {{ number_format($aset->harga_pembelian, 0, ',', '.') }}</td>
                      </tr>
                      @endforeach
                    </tbody>                    
                  </table>
                  
                </div>
                <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
                  <p class="text-dark m-0">
                      Menampilkan
                      <span class="fw-bold">{{ $networkAsets->firstItem() }}</span> -
                      <span class="fw-bold">{{ $networkAsets->lastItem() }}</span>
                      dari Total <span class="fw-bold">{{ $networkAsets->total() }}</span> data
                  </p>
              
                  <!-- Dropdown untuk memilih jumlah item per halaman -->
                  <div class="d-flex align-items-center gap-2">
                      <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                      <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;" onchange="updateItemsPerPage(this.value)">
                          <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                          <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                          <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                          <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                          <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200</option>
                          <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
                          <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000</option>
                      </select>
                  </div>
              
                  <!-- Navigasi halaman -->
                  <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end mb-0">
                          <li class="page-item {{ $networkAsets->onFirstPage() ? 'disabled' : '' }}">
                              <a class="page-link" role="button" aria-label="Sebelumnya" href="{{ $networkAsets->previousPageUrl() }}&perPage={{ request('perPage', 10) }}">
                                  <i class="sym sym-arrow-narrow-left"></i>
                              </a>
                          </li>
                          @foreach ($networkAsets->getUrlRange(1, $networkAsets->lastPage()) as $page => $url)
                              <li class="page-item {{ $networkAsets->currentPage() == $page ? 'active' : '' }}">
                                  <a class="page-link" href="{{ $url }}&perPage={{ request('perPage', 10) }}">{{ $page }}</a>
                              </li>
                          @endforeach
                          <li class="page-item {{ $networkAsets->onLastPage() ? 'disabled' : '' }}">
                              <a class="page-link" href="{{ $networkAsets->nextPageUrl() }}&perPage={{ request('perPage', 10) }}" role="button" aria-label="Selanjutnya">
                                  <i class="sym sym-arrow-narrow-right"></i>
                              </a>
                          </li>
                      </ul>
                  </nav>
                </div>
              
              
              
            </div>
          </div>
        </div>
      </div>
    <!-- [END] Content -->
</main>
@section('footer')
<p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: '{!! session('error') !!}', // Menggunakan `html` agar error bisa multiline
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
<script>
    function updateItemsPerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = url.toString();
    }
</script>

  <script>
      window.addEventListener('DOMContentLoaded', function() {
          const form = document.getElementById("filterForm");
          const checkboxes = document.querySelectorAll('.form-check-input');
          checkboxes.forEach((checkbox) => {
              checkbox.addEventListener("change", () => {
                  form.submit();
              });
          });
      })
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        let toggleBtn = document.querySelector(".toggle-btn");
    
        // Membuat elemen ikon dan menambahkannya ke tombol
        let icon = document.createElement("i");
        icon.classList.add("sym", "sym-arrow-narrow-right-solid"); // Default ikon right
        toggleBtn.appendChild(icon); // Menambahkan ikon ke dalam tombol
    
        // Memperbarui status ikon berdasarkan status collapse saat pertama kali dimuat
        let collapseElement = document.querySelector(".collapse-depreciation");
        if (collapseElement && collapseElement.classList.contains("show")) {
            // Jika collapse terbuka, ganti ikon menjadi left
            icon.classList.replace("sym-arrow-narrow-right-solid", "sym-arrow-narrow-left-solid");
        }
    
        // Memperbarui status ikon setiap kali tombol diklik
        toggleBtn.addEventListener("click", function () {
            if (collapseElement.classList.contains("show")) {
                // Jika collapse terbuka, ubah ikon menjadi kiri
                icon.classList.replace("sym-arrow-narrow-right-solid", "sym-arrow-narrow-left-solid");
            } else {
                // Jika collapse tertutup, ubah ikon menjadi kanan
                icon.classList.replace("sym-arrow-narrow-left-solid", "sym-arrow-narrow-right-solid");
            }
        });
    });
    
    </script>
@endsection



