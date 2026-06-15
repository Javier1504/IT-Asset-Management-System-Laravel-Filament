<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th style="width: 50px;">No</th>
                <th>Tanggal</th>
                <th style="width: 80px;">Qty</th>
                <th>Keterangan</th>
                <th>Nomor BA Pengembalian</th>
                <th style="width: 120px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($checkins as $entry)
                <tr>
                    <td>{{ ($checkins->currentPage() - 1) * $checkins->perPage() + $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $entry->qty }}</td>
                    <td>{{ $entry->alasan ?? '-' }}</td>
                    <td>{{ $entry->bastPengembalianAset->nomor_surat ?? '-' }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-1">
                            <button type="button" class="btn btn-icon btn-sm btn-outline-secondary"
                                onclick="editData({{ $entry->id }}, '{{ $entry->tipe }}', {{ $entry->qty }}, '{{ $entry->alasan ?? '-' }}', {{ $entry->user_id ?? 'null' }}, {{ $entry->aset_id ?? 'null' }}, '{{ $entry->tanggal }}')"
                                title="Edit">
                                <i class="sym sym-edit-solid"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-sm btn-outline-danger"
                                onclick="confirmDelete({{ $entry->id }})" title="Hapus">
                                <i class="sym sym-trash-solid"></i>
                            </button>
                            <form id="delete-form-{{ $entry->id }}"
                                action="{{ route('checkin-checkout-spareparts.destroy', $entry->id) }}" method="POST"
                                class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data check-in.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
@if ($checkins->hasPages())
    <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4">
        <p class="text-dark m-0">
            Menampilkan
            <span class="fw-bold">{{ $checkins->firstItem() ?? 0 }}</span> -
            <span class="fw-bold">{{ $checkins->lastItem() ?? 0 }}</span>
            dari Total <span class="fw-bold">{{ $checkins->total() }}</span> data
        </p>

        <div class="d-flex align-items-center gap-2">
            <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
            <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
                onchange="updateItemsPerPage(this.value)">
                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                <option value="150" {{ request('perPage') == 150 ? 'selected' : '' }}>150</option>
            </select>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end mb-0">
                @php
                    $currentPage = $checkins->currentPage();
                    $lastPage = $checkins->lastPage();
                @endphp
                <li class="page-item {{ $checkins->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link"
                        href="{{ $checkins->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                        <i class="sym sym-arrow-narrow-left"></i>
                    </a>
                </li>

                @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                    <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $checkins->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                    </li>
                @endfor

                @if ($lastPage > 4)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                @if ($lastPage > 3)
                    <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $checkins->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                    </li>
                @endif

                <li class="page-item {{ $checkins->onLastPage() ? 'disabled' : '' }}">
                    <a class="page-link"
                        href="{{ $checkins->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                        <i class="sym sym-arrow-narrow-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endif
