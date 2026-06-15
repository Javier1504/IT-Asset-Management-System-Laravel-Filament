<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Average Rating -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
            <div class="card-body text-white d-flex flex-column justify-content-between">

                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <i class="fas fa-star fa-2x opacity-75"></i>

                        <span class="badge bg-light text-dark fw-semibold px-3 py-2 rounded-pill">
                            {{ $ratingStatus }}
                        </span>
                    </div>

                    <h2 class="mb-0 fw-bold">{{ number_format($averageRating, 1) }}</h2>
                    <small class="opacity-90">Rata-rata Rating</small>

                    <div class="mt-2">
                        <small class="opacity-90">
                            Target: {{ number_format($ratingTarget, 1) }}
                            @if ($averageRating < $ratingTarget)
                                (Kurang {{ abs($ratingGap) }})
                            @else
                                (+{{ $ratingGap }})
                            @endif
                        </small>
                    </div>

                    <div class="mt-1">
                        <small class="opacity-90">
                            Total {{ $totalReviews }} ulasan
                        </small>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="progress" style="height: 8px; border-radius: 20px;">
                        <div class="progress-bar bg-white" role="progressbar"
                            style="width: {{ ($averageRating / 5) * 100 }}%; border-radius: 20px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Total Reviews -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100"
            style="background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-comments fa-2x opacity-75"></i>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-0 fw-bold">{{ number_format($totalReviews) }}</h2>
                        <small class="opacity-90">Total Ulasan</small>
                    </div>
                    <div class="col-6">
                        <h2 class="mb-0 fw-bold">{{ number_format($totalTicket) }}</h2>
                        <small class="opacity-90">Total Tiket</small>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-top">
                    <div class="row text-center small">
                        <div class="col-3">
                            <div class="fw-bold">{{ number_format($totalTicketAsetMaintenance) }}</div>
                            <small class="opacity-75" style="font-size: 0.7rem;">Maintenance</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold">{{ number_format($totalTicketBAset) }}</div>
                            <small class="opacity-75" style="font-size: 0.7rem;">Serah Terima Aset</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold">{{ number_format($totalTicketBAPengembalian) }}</div>
                            <small class="opacity-75" style="font-size: 0.7rem;">Pengembalian Aset</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold">{{ number_format($totalTicketBAPersetujuanAsetPribadi) }}</div>
                            <small class="opacity-75" style="font-size: 0.7rem;">Aset Pribadi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Positive Reviews -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100"
            style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);">
            <div class="card-body text-white d-flex flex-column justify-content-between">

                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <i class="fas fa-thumbs-up fa-2x opacity-75"></i>

                        <span class="badge bg-light text-dark fw-semibold px-3 py-2 rounded-pill">
                            {{ $csatStatus }}
                        </span>
                    </div>

                    <h2 class="mb-0 fw-bold">{{ $positivePercentage }}%</h2>
                    <small class="opacity-90">Ulasan Positif</small>

                    <div class="mt-2">
                        <small class="opacity-90">
                            {{ $satisfiedTickets }} dari {{ $totalReviews }} tiket puas
                        </small>
                    </div>

                    <div class="mt-2">
                        <small class="opacity-90">
                            Target: {{ $csatTarget }}%
                            @if ($positivePercentage < $csatTarget)
                                (Kurang {{ abs($csatGap) }}%)
                            @else
                                (+{{ $csatGap }}%)
                            @endif
                        </small>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="progress" style="height: 8px; border-radius: 20px;">
                        <div class="progress-bar bg-white" role="progressbar"
                            style="width: {{ $positivePercentage }}%; border-radius: 20px;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Negative Reviews -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100"
            style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);">
            <div class="card-body text-white d-flex flex-column justify-content-between">

                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <i class="fas fa-thumbs-down fa-2x opacity-75"></i>

                        <span class="badge bg-light text-dark fw-semibold px-3 py-2 rounded-pill">
                            {{ $negativeStatus }}
                        </span>
                    </div>

                    <h2 class="mb-0 fw-bold">{{ $negativePercentage }}%</h2>
                    <small class="opacity-90">Ulasan Negatif</small>

                    <div class="mt-2">
                        <small class="opacity-90">
                            {{ $unsatisfiedTickets }} dari {{ $totalReviews }} tiket tidak puas
                        </small>
                    </div>

                    <div class="mt-2">
                        <small class="opacity-90">
                            Target maksimal: {{ $negativeTarget }}%
                            @if ($negativePercentage > $negativeTarget)
                                (Lebih {{ $negativeGap }}%)
                            @else
                                (Aman)
                            @endif
                        </small>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="progress" style="height: 8px; border-radius: 20px;">
                        <div class="progress-bar bg-white" role="progressbar"
                            style="width: {{ $negativePercentage }}%; border-radius: 20px;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
