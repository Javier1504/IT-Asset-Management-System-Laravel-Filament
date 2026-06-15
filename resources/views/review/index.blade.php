@extends('layouts.admin')

@section('title', 'Rekap Semua Ulasan')

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

                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Ulasan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Rekap Semua Ulasan</li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0 mb-4">Rekap Semua Ulasan</h4>

                        @include('review.partials.card-resume-review')

                        <!-- Charts Row -->
                        <div class="row g-3 mb-4">
                            <!-- Rating Distribution -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Distribusi Rating</h5>
                                        <div class="rating-distribution">
                                            @foreach ($ratingDistribution as $star => $count)
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <span class="fw-medium">{{ $star }} Bintang</span>
                                                        <span class="text-muted">{{ number_format($count) }}</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        @php
                                                            $percentage =
                                                                $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                            $color =
                                                                $star >= 4
                                                                    ? '#56ab2f'
                                                                    : ($star == 3
                                                                        ? '#ffc107'
                                                                        : ($star == 2
                                                                            ? '#ff9800'
                                                                            : '#ff6b6b'));
                                                        @endphp
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $percentage }}%; background-color: {{ $color }};"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Trends Chart -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Tren Ulasan</h5>
                                        <div style="position: relative; height: 300px;">
                                            <canvas id="reviewTrendsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top Feedback Section -->
                        <div class="row g-3 mb-4">
                            <!-- Top 5 Positive Feedback (4-5) -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3 text-success">
                                            <i class="fas fa-thumbs-up"></i> Top 5 Feedback Positif (Rating 4-5)
                                        </h5>
                                        @if($positiveBreakdown->isEmpty())
                                            <p class="text-muted">Belum ada feedback positif</p>
                                        @else
                                            <div class="list-group list-group-flush">
                                                @foreach($positiveBreakdown as $index => $feedback)
                                                    <div class="list-group-item border-0 px-0 py-2">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-success rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ $index + 1 }}
                                                                </span>
                                                                <span class="fw-medium">{{ $feedback['reason'] }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-success-subtle text-success">
                                                                    {{ $feedback['count'] }} feedback
                                                                </span>
                                                                <span class="text-success fw-bold">
                                                                    {{ $feedback['percentage'] }}%
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="progress" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $feedback['percentage'] }}%"
                                                                aria-valuenow="{{ $feedback['percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Top 5 Negative Feedback (1-3) -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3 text-danger">
                                            <i class="fas fa-thumbs-down"></i> Top 5 Feedback Negatif (Rating 1-3)
                                        </h5>
                                        @if($negativeBreakdown->isEmpty())
                                            <p class="text-muted">Belum ada feedback negatif</p>
                                        @else
                                            <div class="list-group list-group-flush">
                                                @foreach($negativeBreakdown as $index => $feedback)
                                                    <div class="list-group-item border-0 px-0 py-2">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-danger rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ $index + 1 }}
                                                                </span>
                                                                <span class="fw-medium">{{ $feedback['reason'] }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-danger-subtle text-danger">
                                                                    {{ $feedback['count'] }} feedback
                                                                </span>
                                                                <span class="text-danger fw-bold">
                                                                    {{ $feedback['percentage'] }}%
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="progress" style="height: 6px;">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                style="width: {{ $feedback['percentage'] }}%"
                                                                aria-valuenow="{{ $feedback['percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly CSAT Statistics -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">
                                            <i class="fas fa-chart-line"></i> Statistik Bulanan (12 Bulan Terakhir)
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th class="text-center">Total Tiket</th>
                                                        <th class="text-center">Tiket Puas (≥4)</th>
                                                        <th class="text-center">Rata-rata Rating</th>
                                                        <th class="text-center">Overall Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($monthlyTickets as $monthly)
                                                        @php
                                                            $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $monthly->month);
                                                            $csatColor = $monthly->csat_score >= 80 ? 'success' : ($monthly->csat_score >= 60 ? 'warning' : 'danger');
                                                        @endphp
                                                        <tr>
                                                            <td class="fw-medium">{{ $monthDate->format('F Y') }}</td>
                                                            <td class="text-center">
                                                                <span class="badge bg-primary">{{ number_format($monthly->total_tickets) }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-success">{{ number_format($monthly->satisfied_tickets) }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                                    <i class="fas fa-star text-warning"></i>
                                                                    <span class="fw-bold">{{ number_format($monthly->avg_rating, 2) }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-{{ $csatColor }}-subtle text-{{ $csatColor }} fs-6">
                                                                    {{ number_format($monthly->csat_score, 2) }}%
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <form action="" id="categories" method="GET">
                            <div class="row d-flex align-items-center justify-content-between gap-2">
                                <div class="col-md-3">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control" name="search" placeholder="Cari.."
                                                value="{{ request('search') }}" autocomplete="off">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="month" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Bulan</option>
                                        @foreach($availableMonths as $month)
                                            @php
                                                $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $month);
                                            @endphp
                                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                {{ $monthDate->format('F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex justify-content-end gap-2">
                                    @if(request()->hasAny(['search', 'month']))
                                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                                            <i class="sym sym-close"></i> Reset Filter
                                        </a>
                                    @endif
                                    <a href="{{ route('reviews.export', request()->all()) }}"
                                        class="btn btn-success d-block d-lg-inline-block" aria-label="Ekspor Data">
                                        <i class="sym sym-download"></i> Ekspor Data
                                    </a>
                                </div>
                            </div>
                        </form>
                        @include('review.partials.table-review')
                    </div>
                </div>
            </div>
        </div>
        <!-- [END] Content -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Review Trends Chart
            const ctx = document.getElementById('reviewTrendsChart');

            if (!ctx) return; // Exit if canvas not found

            const trendData = @json($reviewTrends);

            const months = trendData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('id-ID', {
                    month: 'short',
                    year: 'numeric'
                });
            });

            const reviewCounts = trendData.map(item => item.count);
            const avgRatings = trendData.map(item => parseFloat(item.avg_rating).toFixed(2));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Jumlah Ulasan',
                            data: reviewCounts,
                            borderColor: '#00b4db',
                            backgroundColor: 'rgba(0, 180, 219, 0.1)',
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Rata-rata Rating',
                            data: avgRatings,
                            borderColor: '#56ab2f',
                            backgroundColor: 'rgba(86, 171, 47, 0.1)',
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#ddd',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Jumlah Ulasan'
                            },
                            beginAtZero: true
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Rata-rata Rating'
                            },
                            min: 0,
                            max: 5,
                            grid: {
                                drawOnChartArea: false,
                            }
                        }
                    }
                }
            });
        });
    </script>

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
        function updateItemsPerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1); // Reset ke halaman pertama
            window.location.href = url.toString();
        }
    </script>

    @section('footer')
        <p></p>
    @endsection

@endsection
