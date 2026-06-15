<!-- [START] Card for Bukti Dokumen Barang -->
<div class="card shadow-sm border-0 rounded-4 p-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="m-0">Bukti Dokumen Barang</h4>
        </div>

        @if ($babp->details && $babp->details->count() > 0)
            <div class="row g-4">
                @foreach ($babp->details as $index => $detail)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">{{ $detail->nama_barang }}</h6>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if ($detail->image)
                                    <div class="text-center mb-3 position-relative">
                                        <img src="{{ asset('storage/' . $detail->image) }}"
                                            alt="{{ $detail->nama_barang }}" class="img-fluid rounded shadow-sm"
                                            style="max-height: 200px; width: 100%; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            onclick="showImageModal('{{ asset('storage/' . $detail->image) }}', '{{ $detail->nama_barang }}')">

                                        @php
                                            $statusClass = match ($detail->status) {
                                                'completed' => 'bg-success',
                                                'returned' => 'bg-info',
                                                'damaged' => 'bg-danger',
                                                'waiting' => 'bg-warning',
                                                default => 'bg-secondary',
                                            };
                                            $statusText = match ($detail->status) {
                                                'completed' => 'Selesai',
                                                'returned' => 'Dikembalikan',
                                                'damaged' => 'Rusak',
                                                'waiting' => 'Menunggu',
                                                default => 'N/A',
                                            };
                                        @endphp

                                        <span class="badge {{ $statusClass }} position-absolute top-0 end-0 m-2">
                                            {{ $statusText }}
                                        </span>
                                        @if ($detail->invoice)
                                            <div class="top-50 start-50 translate-middle position-absolute">
                                                <a href="{{ asset('storage/' . $detail->invoice) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="sym sym-file-line"></i> Lihat Bukti Pembelian
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4 mb-3">
                                        <i class="sym sym-image-line fs-1 mb-2"></i>
                                        <p class="small mb-0">Tidak ada gambar</p>
                                    </div>
                                @endif

                                <div class="mt-auto">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted small">Kuantitas Dipesan:</td>
                                            <td class="small"><strong>{{ $detail->kuantitas_dipesan }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted small">Kuantitas Diterima:</td>
                                            <td class="small"><strong>{{ $detail->kuantitas_diterima }}</strong></td>
                                        </tr>
                                        @if ($detail->tanggal_beli)
                                            <tr>
                                                <td class="text-muted small">Tanggal Beli:</td>
                                                <td class="small">
                                                    {{ \Carbon\Carbon::parse($detail->tanggal_beli)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($detail->tanggal_terima)
                                            <tr>
                                                <td class="text-muted small">Tanggal Terima:</td>
                                                <td class="small">
                                                    {{ \Carbon\Carbon::parse($detail->tanggal_terima)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>

                                    @if ($detail->notes)
                                        <div class="alert alert-info py-2 px-2 mt-2 mb-0">
                                            <small><strong>Catatan:</strong><br>{{ $detail->notes }}</small>
                                        </div>
                                    @endif

                                    @can('akses-admin-superadmin')
                                        <form action="{{ route('babp.detail.update-status', $detail->id) }}" method="POST"
                                            class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label class="form-label small mb-1">Update Status:</label>
                                                <select name="status" class="form-select form-select-sm" required>
                                                    <option value="waiting"
                                                        {{ $detail->status === 'waiting' ? 'selected' : '' }}>Menunggu
                                                    </option>
                                                    <option value="completed"
                                                        {{ $detail->status === 'completed' ? 'selected' : '' }}>Selesai
                                                    </option>
                                                    <option value="returned"
                                                        {{ $detail->status === 'returned' ? 'selected' : '' }}>Dikembalikan
                                                    </option>
                                                    <option value="damaged"
                                                        {{ $detail->status === 'damaged' ? 'selected' : '' }}>Rusak
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small mb-1">Catatan:</label>
                                                <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Tambahkan catatan...">{{ $detail->notes }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary w-100">Simpan</button>
                                        </form>
                                    @endcan
                                </div>

                                @if ($detail->image)
                                    <p class="text-muted small text-center mt-2 mb-0">Klik gambar untuk melihat detail
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-4">
                <i class="sym sym-file-list-line fs-1 mb-2"></i>
                <p>Tidak ada detail barang yang tercatat</p>
            </div>
        @endif
    </div>
</div>
