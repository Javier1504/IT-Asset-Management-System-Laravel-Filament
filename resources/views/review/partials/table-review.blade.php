<div class="table-responsive mt-4">
    <table class="table table-bordered align-middle">
        <thead class="align-middle">
            <tr class="table-light">
                <th style="min-width: 36px; width: 36px;">No</th>
                <th style="min-width: 300px; width: 10%;">
                    <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Nama Reviewer">
                        Nama Reviewer
                        <i class="float-end sym sym-switch-vertical"></i>
                    </button>
                </th>
                <th style="min-width: 200px; width: 10%;">
                    <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Dokumen">
                        Dokumen
                        <i class="float-end sym sym-switch-vertical"></i>
                    </button>
                </th>
                <th style="min-width: 200px; width: 10%;">
                    <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Rating">
                        Rating
                        <i class="float-end sym sym-switch-vertical"></i>
                    </button>
                </th>
                <th style="min-width: 300px; width: 10%;">
                    <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Rating Detail">
                        Rating Detail
                        <i class="float-end sym sym-switch-vertical"></i>
                    </button>
                </th>
                <th style="min-width: 400px; width: 10%;">
                    <button class="btn p-0 border-0 w-100 h-100 text-start" aria-label="Komentar">
                        Komentar
                        <i class="float-end sym sym-switch-vertical"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}
                    </td>
                    <td>
                        @if ($review->is_anonymous === true)
                            Anonymous
                        @else
                            {{ $review->reviewer->name_karyawan }}
                        @endif
                    </td>
                    <td>
                        {{ $review->reference_type }}
                    </td>
                    <td>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <i class="fas fa-star" style="color: #ffc107;"></i>
                            @else
                                <i class="far fa-star" style="color: #ffc107;"></i>
                            @endif
                        @endfor
                    </td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @if ($review->rating_details)
                                @foreach ($review->rating_details as $key => $value)
                                    <li>
                                        {{ $value }}
                                    </li>
                                @endforeach
                            @else
                                <li>No rating details available</li>
                            @endif
                        </ul>
                    </td>
                    <td>
                        {{ $review->review }}
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4 pt-md-0">
    <p class="text-dark m-0">
        Menampilkan
        <span class="fw-bold">{{ $reviews->firstItem() }}</span> -
        <span class="fw-bold">{{ $reviews->lastItem() }}</span>
        dari Total <span class="fw-bold">{{ $reviews->total() }}</span> data
    </p>

    <!-- Dropdown untuk memilih jumlah item per halaman -->
    <div class="d-flex align-items-center gap-2">
        <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
        <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
            onchange="updateItemsPerPage(this.value)">
            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
            <option value="200" {{ request('perPage') == 200 ? 'selected' : '' }}>200</option>
            <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
            <option value="1000" {{ request('perPage') == 1000 ? 'selected' : '' }}>1000
            </option>
        </select>
    </div>
    <!-- Navigasi halaman -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end mb-0">

            @php
                $currentPage = $reviews->currentPage();
                $lastPage = $reviews->lastPage();
            @endphp

            <!-- Tombol Sebelumnya -->
            <li class="page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $reviews->appends(request()->query())->previousPageUrl() }}">
                    <i class="sym sym-arrow-narrow-left"></i>
                </a>
            </li>

            @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                    <a class="page-link"
                        href="{{ $reviews->appends(request()->query())->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            @if ($lastPage > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            @if ($lastPage > 3)
                <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                    <a class="page-link"
                        href="{{ $reviews->appends(request()->query())->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            <!-- Tombol Selanjutnya -->
            <li class="page-item {{ $reviews->onLastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $reviews->appends(request()->query())->nextPageUrl() }}">
                    <i class="sym sym-arrow-narrow-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
