@if ($babp->evidence)
    @php
        $evidenceFiles = json_decode($babp->evidence, true);
    @endphp
    @if (is_array($evidenceFiles) && count($evidenceFiles) > 0)
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="m-0">Dokumen Bukti Pendukung</h4>
                    <span class="badge bg-primary">{{ count($evidenceFiles) }} File</span>
                </div>

                <div class="row g-3">
                    @foreach ($evidenceFiles as $index => $evidencePath)
                        @php
                            $fileExtension = strtolower(pathinfo($evidencePath, PATHINFO_EXTENSION));
                            $fileName = basename($evidencePath);
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png']);
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card border h-100">
                                <div class="card-body d-flex flex-column">
                                    @if ($isImage)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $evidencePath) }}"
                                                alt="Evidence {{ $index + 1 }}" class="img-fluid rounded shadow-sm"
                                                style="max-height: 200px; width: 100%; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImageModal('{{ asset('storage/' . $evidencePath) }}', 'Evidence {{ $index + 1 }}')">
                                        </div>
                                    @else
                                        <div class="text-center py-4 mb-3 bg-light rounded">
                                            <i class="sym sym-file-pdf-line fs-1 text-danger mb-2"></i>
                                            <p class="small mb-0 text-muted">PDF Document</p>
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <p class="small text-muted mb-2 text-truncate" title="{{ $fileName }}">
                                            {{ $fileName }}
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset('storage/' . $evidencePath) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="sym sym-eye-line"></i> Lihat
                                            </a>
                                            <a href="{{ asset('storage/' . $evidencePath) }}" download
                                                class="btn btn-sm btn-outline-secondary flex-fill">
                                                <i class="sym sym-download-line"></i> Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
