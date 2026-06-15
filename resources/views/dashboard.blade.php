@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')

    <style>
        /* Modern Dashboard Styles */
        .dash-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .dash-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .dash-stat-card {
            border: none;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .dash-stat-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            opacity: 0.1;
        }

        .dash-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .dash-badge {
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .dash-section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .dash-section-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .progress-thin {
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
        }

        .progress-thin .progress-bar {
            border-radius: 3px;
        }

        .ticket-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .priority-badge {
            font-size: 0.7rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .trend-chart-container {
            height: 200px;
        }

        .metric-card {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #fff;
        }

        .dash-welcome {
            background: linear-gradient(135deg, #39539D 0%, #5b7fd4 100%);
            border-radius: 20px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .dash-welcome::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .dash-welcome::before {
            content: '';
            position: absolute;
            bottom: -40%;
            right: 15%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        {{-- ALERT SESSION --}}
        @if (session('alert_message'))
            <div class="container mt-3">
                <div class="alert alert-{{ session('alert_type', 'primary') }} alert-dismissible fade show d-flex gap-2"
                    style="border-radius: 12px;">
                    <i class="sym sym-check-verified-02-solid"></i>
                    <div class="d-block">
                        @if (session('alert_title'))
                            <h6 class="alert-heading">{{ session('alert_title') }}</h6>
                        @endif
                        {!! session('alert_message') !!}
                    </div>
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <!-- Breadcrumb -->
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-1">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Beranda</a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                @php
                    $authUser = auth()->user();
                    $isFusionTeamLeader = false;

                    if ($authUser && \Illuminate\Support\Facades\Schema::hasTable('fusion_sub_team_members')) {
                        $hasFusionLeaderColumn = \Illuminate\Support\Facades\Schema::hasColumn('fusion_sub_team_members', 'is_leader');

                        $isFusionTeamLeader = \App\Models\FusionSubTeamMember::query()
                            ->where('user_id', $authUser->id)
                            ->where(function ($query) use ($hasFusionLeaderColumn) {
                                if ($hasFusionLeaderColumn) {
                                    $query->where('is_leader', true);
                                }

                                $query->orWhereRaw("LOWER(COALESCE(role_label, '')) LIKE ?", ['%team leader%'])
                                    ->orWhereRaw("LOWER(COALESCE(role_label, '')) LIKE ?", ['%leader%']);
                            })
                            ->exists();
                    }
                @endphp

                @if ($isFusionTeamLeader && !in_array($authUser?->role, ['admin', 'super_admin'], true))
                    <div class="dash-card shadow-sm bg-white mb-3" style="border: 1px solid rgba(57, 83, 157, 0.12);">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="dash-stat-icon flex-shrink-0" style="background: #39539D; color: #fff;">
                                        <i class="sym sym-users-check-solid"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Review Stock Opname Tim Saya</h5>
                                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                            Akses khusus Team Leader FUSION untuk melihat anggota sub-tim dan hasil stock opname asetnya.
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('stock-opnames.fusion-review.my') }}"
                                   class="btn btn-primary fw-semibold d-inline-flex align-items-center justify-content-center gap-2"
                                   style="border-radius: 10px; min-width: 230px;">
                                    Buka Review Tim Saya
                                    <i class="sym sym-arrow-narrow-right fs-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif


                @can('akses-admin-superadmin')
                    <!-- ========================================== -->
                    <!--   WELCOME BANNER                           -->
                    <!-- ========================================== -->
                    <div class="dash-welcome p-4 mb-2 shadow-sm">
                        <div class="row align-items-center position-relative" style="z-index: 1;">
                            <div class="col-lg-8">
                                <h4 class="fw-bold mb-1">&#x1F44B; Selamat Datang di Dashboard ITAM</h4>
                                <p class="mb-0 opacity-90" style="font-size: 0.9rem;">
                                    Pantau seluruh aset, tiket perbaikan, dan performa layanan IT dalam satu tampilan.
                                </p>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <span class="badge bg-white bg-opacity-25 px-3 py-2 fw-normal" style="font-size: 0.8rem;">
                                    <i class="sym sym-calendar"></i> {{ now()->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>


                    <!-- ========================================== -->
                    <!--   ASSET STATS CARDS (5 columns)            -->
                    <!-- ========================================== -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 g-3 mb-3">
                        @php
                            $cardStyles = [
                                [
                                    'gradient' => 'linear-gradient(135deg, #39539D 0%, #5b7fd4 100%)',
                                    'icon_bg' => 'rgba(255,255,255,0.2)',
                                    'text' => '#fff',
                                ],
                                [
                                    'gradient' => 'linear-gradient(135deg, #0d6efd 0%, #6ea8fe 100%)',
                                    'icon_bg' => 'rgba(255,255,255,0.2)',
                                    'text' => '#fff',
                                ],
                                [
                                    'gradient' => 'linear-gradient(135deg, #198754 0%, #5dd39e 100%)',
                                    'icon_bg' => 'rgba(255,255,255,0.2)',
                                    'text' => '#fff',
                                ],
                                [
                                    'gradient' => 'linear-gradient(135deg, #dc3545 0%, #f1756f 100%)',
                                    'icon_bg' => 'rgba(255,255,255,0.2)',
                                    'text' => '#fff',
                                ],
                                [
                                    'gradient' => 'linear-gradient(135deg, #fd7e14 0%, #ffc078 100%)',
                                    'icon_bg' => 'rgba(255,255,255,0.2)',
                                    'text' => '#fff',
                                ],
                            ];
                            $cardIcons = [
                                'sym sym-monitor-solid',
                                'sym sym-server-solid',
                                'sym sym-building-03-solid',
                                'sym sym-shield-tick-solid',
                                'sym sym-box-solid',
                            ];
                        @endphp
                        @foreach ($assets as $index => $asset)
                            @php $style = $cardStyles[$index % count($cardStyles)]; @endphp
                            <div class="col">
                                <div class="dash-stat-card shadow-sm h-100" style="background: {{ $style['gradient'] }};">
                                    <div class="card-body p-3 d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="dash-stat-icon"
                                                style="background: {{ $style['icon_bg'] }}; color: {{ $style['text'] }};">
                                                <i class="{{ $cardIcons[$index % count($cardIcons)] }}"></i>
                                            </div>
                                            @if (isset($asset['percentage_change']))
                                                @php
                                                    $change = abs($asset['percentage_change']);
                                                    $isIncrease = $asset['percentage_change'] > 0;
                                                    $isDecrease = $asset['percentage_change'] < 0;
                                                @endphp
                                                <span class="dash-badge"
                                                    style="background: rgba(255,255,255,0.2); color: {{ $style['text'] }};">
                                                    @if ($isIncrease)
                                                        &#x25B2; {{ $change }}%
                                                    @elseif($isDecrease)
                                                        &#x25BC; {{ $change }}%
                                                    @else
                                                        &mdash; {{ $change }}%
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0" style="color: {{ $style['text'] }};">
                                                {{ number_format($asset['count']) }}</h3>
                                            <small
                                                style="color: {{ $style['text'] }}; opacity: 0.85;">{{ $asset['title'] }}</small>
                                        </div>
                                        @if ($asset['title'] == 'End User Aset')
                                            <a href="{{ route('end-user-aset.index') }}"
                                                class="btn btn-sm btn-light mt-auto fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($asset['title'] == 'Physical Host Aset')
                                            <a href="{{ route('physical-host-aset.index') }}"
                                                class="btn btn-sm btn-light mt-auto fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($asset['title'] == 'Office Aset')
                                            <a href="{{ route('office-aset.index') }}"
                                                class="btn btn-sm btn-light mt-auto fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($asset['title'] == 'Security Peripheral')
                                            <a href="{{ route('security-peripheral.index') }}"
                                                class="btn btn-sm btn-light mt-auto fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($asset['title'] == 'Sparepart')
                                            <a href="{{ route('jenis-sparepart.index') }}"
                                                class="btn btn-sm btn-light mt-auto fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ========================================== -->
                    <!--   INFORMATION / INFO CARDS (4 cols)        -->
                    <!-- ========================================== -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-3">
                        @php
                            $infoIcons = [
                                'sym sym-file-check-solid',
                                'sym sym-settings-solid',
                                'sym sym-alert-triangle-solid',
                                'sym sym-users-solid',
                            ];
                            $infoBgColors = ['#eef2ff', '#fff1f2', '#f0fdf4', '#fef9c3'];
                            $infoIconColors = ['#39539D', '#dc3545', '#198754', '#ca8a04'];
                        @endphp
                        @foreach ($infos as $index => $info)
                            <div class="col">
                                <div class="dash-card shadow-sm h-100"
                                    style="background: {{ $infoBgColors[$index % count($infoBgColors)] }};">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <div class="dash-stat-icon"
                                                style="background: {{ $infoIconColors[$index % count($infoIconColors)] }}; color: #fff;">
                                                <i class="{{ $infoIcons[$index % count($infoIcons)] }}"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted fw-semibold">{{ $info['title'] }}</small>
                                                <h3 class="fw-bold mb-0 text-dark">{{ number_format($info['count']) }}</h3>
                                            </div>
                                        </div>

                                        @php
                                            $change = abs($info['percentage_change']);
                                            $isIncrease = $info['percentage_change'] > 0;
                                            $isDecrease = $info['percentage_change'] < 0;
                                        @endphp
                                        <div class="d-flex align-items-center gap-1 mb-2" style="font-size: 0.8rem;">
                                            <span
                                                class="fw-semibold {{ $isIncrease ? 'text-success' : ($isDecrease ? 'text-danger' : 'text-secondary') }}">
                                                @if ($isIncrease)
                                                    &#x25B2; {{ $change }}%
                                                @elseif($isDecrease)
                                                    &#x25BC; {{ $change }}%
                                                @else
                                                    &mdash; {{ $change }}%
                                                @endif
                                            </span>
                                            <span class="text-muted">dari bulan lalu</span>
                                        </div>

                                        @if ($info['title'] == 'Data Permintaan Aset')
                                            <a href="{{ route('aset-request.index') }}"
                                                class="btn btn-sm btn-outline-primary w-100 fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($info['title'] == 'Data Perbaikan Aset')
                                            <a href="{{ route('aset-maintenance.index') }}"
                                                class="btn btn-sm btn-outline-danger w-100 fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($info['title'] == 'Data Aset Tidak Normal')
                                            <a href="{{ route('abnormal-aset.index') }}"
                                                class="btn btn-sm btn-outline-success w-100 fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @elseif($info['title'] == 'Data Pegawai')
                                            <a href="{{ route('users.index') }}"
                                                class="btn btn-sm btn-outline-warning w-100 fw-semibold"
                                                style="border-radius: 8px; font-size: 0.75rem;">
                                                Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ========================================== -->
                    <!--   TICKET RECAP SECTION                     -->
                    <!-- ========================================== -->
                    <div class="row g-3 mb-3">
                        <!-- Ticket Overview Cards -->
                        <div class="col-12">
                            <div class="dash-card shadow-sm bg-white p-4">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="dash-stat-icon" style="background: #39539D; color: #fff;">
                                            <i class="sym sym-ticket-solid"></i>
                                        </div>
                                        <div>
                                            <h5 class="dash-section-title mb-0">Rekap Tiket Perbaikan</h5>
                                            <span class="dash-section-subtitle">Ringkasan status dan prioritas tiket
                                                maintenance</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('aset-maintenance.index') }}" class="btn btn-sm btn-outline-primary"
                                        style="border-radius: 8px;">
                                        Kelola Tiket <i class="sym sym-arrow-narrow-right"></i>
                                    </a>
                                </div>

                                <!-- Ticket Status Summary -->
                                <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
                                    <div class="col">
                                        <div class="metric-card text-center"
                                            style="background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);">
                                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                                <span class="ticket-status-dot" style="background: #3b82f6;"></span>
                                                <small class="text-muted fw-semibold">Open</small>
                                            </div>
                                            <h3 class="fw-bold mb-0" style="color: #1e40af;">
                                                {{ $ticketRecap['open'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="metric-card text-center"
                                            style="background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);">
                                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                                <span class="ticket-status-dot" style="background: #f59e0b;"></span>
                                                <small class="text-muted fw-semibold">On Progress</small>
                                            </div>
                                            <h3 class="fw-bold mb-0" style="color: #92400e;">
                                                {{ $ticketRecap['on_progress'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="metric-card text-center"
                                            style="background: linear-gradient(135deg, #fce7f3 0%, #fdf2f8 100%);">
                                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                                <span class="ticket-status-dot" style="background: #ec4899;"></span>
                                                <small class="text-muted fw-semibold">Pending</small>
                                            </div>
                                            <h3 class="fw-bold mb-0" style="color: #9d174d;">
                                                {{ $ticketRecap['pending'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="metric-card text-center"
                                            style="background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);">
                                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                                <span class="ticket-status-dot" style="background: #10b981;"></span>
                                                <small class="text-muted fw-semibold">Selesai</small>
                                            </div>
                                            <h3 class="fw-bold mb-0" style="color: #065f46;">
                                                {{ $ticketRecap['selesai'] }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- Ticket Trend Chart -->
                                    <div class="col-md-7">
                                        <div class="metric-card h-100">
                                            <h6 class="fw-bold mb-3">
                                                <i class="sym sym-bar-chart-square text-primary me-1"></i>
                                                Tren Tiket 6 Bulan Terakhir
                                            </h6>
                                            <div class="trend-chart-container">
                                                <canvas id="ticketTrendChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Priority & Performance -->
                                    <div class="col-md-5">
                                        <div class="d-flex flex-column gap-3 h-100">
                                            <!-- Priority Breakdown -->
                                            <div class="metric-card flex-grow-1">
                                                <h6 class="fw-bold mb-3">
                                                    <i class="sym sym-flag-solid text-danger me-1"></i>
                                                    Tiket Aktif per Prioritas
                                                </h6>
                                                <div class="d-flex flex-column gap-2">
                                                    @php
                                                        $activeTotal =
                                                            $ticketRecap['critical'] +
                                                            $ticketRecap['high'] +
                                                            $ticketRecap['medium'] +
                                                            $ticketRecap['low'];
                                                    @endphp
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="priority-badge bg-danger text-white">Critical</span>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 flex-grow-1 mx-3">
                                                            <div class="progress-thin flex-grow-1">
                                                                <div class="progress-bar bg-danger"
                                                                    style="width: {{ $activeTotal > 0 ? ($ticketRecap['critical'] / $activeTotal) * 100 : 0 }}%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $ticketRecap['critical'] }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="priority-badge bg-warning text-dark">High</span>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 flex-grow-1 mx-3">
                                                            <div class="progress-thin flex-grow-1">
                                                                <div class="progress-bar bg-warning"
                                                                    style="width: {{ $activeTotal > 0 ? ($ticketRecap['high'] / $activeTotal) * 100 : 0 }}%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $ticketRecap['high'] }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="priority-badge bg-info text-white">Medium</span>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 flex-grow-1 mx-3">
                                                            <div class="progress-thin flex-grow-1">
                                                                <div class="progress-bar bg-info"
                                                                    style="width: {{ $activeTotal > 0 ? ($ticketRecap['medium'] / $activeTotal) * 100 : 0 }}%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $ticketRecap['medium'] }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="priority-badge bg-secondary text-white">Low</span>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 flex-grow-1 mx-3">
                                                            <div class="progress-thin flex-grow-1">
                                                                <div class="progress-bar bg-secondary"
                                                                    style="width: {{ $activeTotal > 0 ? ($ticketRecap['low'] / $activeTotal) * 100 : 0 }}%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $ticketRecap['low'] }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Performance Metrics -->
                                            <div class="metric-card">
                                                <h6 class="fw-bold mb-3">
                                                    <i class="sym sym-clock text-warning me-1"></i>
                                                    Performa Layanan
                                                </h6>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="text-center p-2 rounded-3" style="background: #f8f9fa;">
                                                            <h4 class="fw-bold mb-0 text-primary">
                                                                {{ $ticketRecap['avg_resolution_hours'] }}
                                                                <small class="fw-normal" style="font-size: 0.6em;">jam</small>
                                                            </h4>
                                                            <small class="text-muted" style="font-size: 0.7rem;">Rata-rata
                                                                Resolusi</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center p-2 rounded-3" style="background: #f8f9fa;">
                                                            <h4 class="fw-bold mb-0"
                                                                style="color: {{ $ticketRecap['avg_rating'] >= 4 ? '#198754' : ($ticketRecap['avg_rating'] >= 3 ? '#fd7e14' : '#dc3545') }};">
                                                                {{ $ticketRecap['avg_rating'] }}
                                                                <small class="fw-normal" style="font-size: 0.6em;">/ 5</small>
                                                            </h4>
                                                            <small class="text-muted" style="font-size: 0.7rem;">Rating
                                                                Layanan</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-center p-2 rounded-3"
                                                            style="background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);">
                                                            <div
                                                                class="d-flex align-items-center justify-content-center gap-2">
                                                                <h4 class="fw-bold mb-0" style="color: #065f46;">
                                                                    {{ $ticketRecap['csat_percentage'] }}%</h4>
                                                                <span
                                                                    class="badge {{ $ticketRecap['csat_percentage'] >= 90 ? 'bg-success' : ($ticketRecap['csat_percentage'] >= 70 ? 'bg-warning text-dark' : 'bg-danger') }}"
                                                                    style="font-size: 0.65rem;">
                                                                    {{ $ticketRecap['csat_percentage'] >= 90 ? 'Excellent' : ($ticketRecap['csat_percentage'] >= 70 ? 'Good' : 'Needs Improvement') }}
                                                                </span>
                                                            </div>
                                                            <small class="text-muted" style="font-size: 0.7rem;">CSAT
                                                                ({{ $ticketRecap['satisfied_reviews'] }}/{{ $ticketRecap['total_reviews'] }}
                                                                puas)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!--   JENIS PERANGKAT MAINTENANCE CHART        -->
                    <!-- ========================================== -->
                    @if($ticketRecap['jenis_perangkat']->isNotEmpty())
                    <div class="row mb-3 g-3">
                        <div class="col-md-12">
                            <div class="dash-card shadow-sm bg-white p-3 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 p-2 mb-2">
                                    <div class="dash-stat-icon" style="background: #39539D; color: #fff;">
                                        <i class="sym sym-activity"></i>
                                    </div>
                                    <div>
                                        <h6 class="dash-section-title mb-0">Jenis Perangkat Sering Di-Maintenance</h6>
                                        <span class="dash-section-subtitle">Top 10 jenis perangkat berdasarkan frekuensi maintenance</span>
                                    </div>
                                </div>
                                <div class="p-3" style="min-height: 300px;">
                                    <canvas id="jenisPerangkatChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ========================================== -->
                    <!--   ASSET STATUS CHART & RECENT ACTIVITY     -->
                    <!-- ==========================================  -->
                    <div class="row mb-3 g-3">
                        <div class="col-md-6">
                            <div class="dash-card shadow-sm bg-white p-3 d-flex flex-column" style="min-height: 470px;">
                                <div class="d-flex align-items-center gap-3 p-2 mb-2">
                                    <div class="dash-stat-icon" style="background: #39539D; color: #fff;">
                                        <i class="sym sym-layers-three-solid"></i>
                                    </div>
                                    <div>
                                        <h6 class="dash-section-title mb-0">Aset Berdasarkan Status</h6>
                                        <span class="dash-section-subtitle">Distribusi aset berdasarkan kondisi</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 d-flex justify-content-center align-items-center p-3"
                                    style="min-height: 300px;">
                                    <canvas id="assetStatusChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="dash-card shadow-sm bg-white p-3 d-flex flex-column" style="min-height: 470px;">
                                <div class="d-flex align-items-center gap-3 p-2 mb-2">
                                    <div class="dash-stat-icon" style="background: #ED2427; color: #fff;">
                                        <i class="sym sym-activity"></i>
                                    </div>
                                    <div>
                                        <h6 class="dash-section-title mb-0">Aktivitas Terkini</h6>
                                        <span class="dash-section-subtitle">Aktivitas terbaru yang terjadi</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 d-flex flex-column p-2" style="min-height: 300px;">
                                    <div class="table-responsive flex-grow-1" style="max-height: 320px; overflow: auto;">
                                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                            <thead class="sticky-top">
                                                <tr style="background: #f8f9fa;">
                                                    <th style="min-width: 36px; width: 36px; border-radius: 8px 0 0 8px;">No
                                                    </th>
                                                    <th style="min-width: 175px;">Nama Aset</th>
                                                    <th style="min-width: 240px; border-radius: 0 8px 8px 0;">Aktivitas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($activities->isEmpty())
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted py-4">
                                                            <i class="sym sym-inbox fs-3 d-block mb-2 text-secondary"></i>
                                                            Belum ada aktivitas terbaru.
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($activities as $index => $activity)
                                                        <tr>
                                                            <td class="text-muted">
                                                                {{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}
                                                            </td>
                                                            <td class="fw-semibold">
                                                                {{ ($activity->aset->jenisAset->name_jenis ?? 'Tidak diketahui') . ' - ' . ($activity->aset->merk_aset ?? 'Tidak diketahui') }}
                                                            </td>
                                                            <td>
                                                                <span class="text-muted">{{ $activity->description }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <nav aria-label="Activity pagination" class="mt-auto pt-2">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @php
                                                $currentPage = $activities->currentPage();
                                                $lastPage = $activities->lastPage();
                                            @endphp
                                            <li class="page-item {{ $activities->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $activities->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-left"></i>
                                                </a>
                                            </li>
                                            @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $activities->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                                </li>
                                            @endfor
                                            @if ($lastPage > 4)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            @if ($lastPage > 3)
                                                <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $activities->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                                </li>
                                            @endif
                                            <li class="page-item {{ $activities->onLastPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $activities->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!--   ASSET CATEGORY & LOCATION TABLES         -->
                    <!-- ========================================== -->
                    <div class="row mb-3 g-3">
                        <div class="col-md-6">
                            <div class="dash-card shadow-sm bg-white p-3 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 p-2 mb-2">
                                    <div class="dash-stat-icon" style="background: #ED2427; color: #fff;">
                                        <i class="sym sym-layout-alt-04-solid"></i>
                                    </div>
                                    <div>
                                        <h6 class="dash-section-title mb-0">Aset Berdasarkan Kategori</h6>
                                        <span class="dash-section-subtitle">Data jenis aset berdasarkan kategorinya</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 d-flex flex-column p-2" style="min-height: 300px;">
                                    <div id="pagination-data" class="table-responsive flex-grow-1"
                                        style="max-height: 320px; overflow: auto;">
                                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                            <thead class="sticky-top">
                                                <tr style="background: #f8f9fa;">
                                                    <th style="min-width: 36px; width: 36px; border-radius: 8px 0 0 8px;">No
                                                    </th>
                                                    <th style="min-width: 200px;">Nama Jenis</th>
                                                    <th style="min-width: 200px;">Kategori</th>
                                                    <th style="min-width: 80px; border-radius: 0 8px 8px 0;">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pagedData as $data)
                                                    <tr>
                                                        <td class="text-muted">
                                                            {{ ($pagedData->currentPage() - 1) * $pagedData->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td class="fw-semibold">
                                                            {{ $data['name_jenis'] ?? $data['jenis_sparepart'] }}</td>
                                                        <td class="text-capitalize text-muted">
                                                            {{ str_replace('_', ' ', $data['category']) }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1"
                                                                style="border-radius: 6px;">{{ $data['jumlah'] }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if ($pagedData->isEmpty())
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-4">
                                                            <i class="sym sym-inbox fs-3 d-block mb-2 text-secondary"></i>
                                                            Belum ada data aset.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <nav aria-label="Category pagination" class="mt-auto pt-2">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @php
                                                $currentPage = $pagedData->currentPage();
                                                $lastPage = $pagedData->lastPage();
                                            @endphp
                                            <li class="page-item {{ $pagedData->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $pagedData->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-left"></i>
                                                </a>
                                            </li>
                                            @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $pagedData->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                                </li>
                                            @endfor
                                            @if ($lastPage > 4)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            @if ($lastPage > 3)
                                                <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $pagedData->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                                </li>
                                            @endif
                                            <li class="page-item {{ $pagedData->onLastPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $pagedData->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <a href="{{ route('jenis-aset.index') }}" class="btn btn-primary mt-2 w-100 fw-semibold"
                                        style="border-radius: 10px;">
                                        Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="dash-card shadow-sm bg-white p-3 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 p-2 mb-2">
                                    <div class="dash-stat-icon" style="background: #ED2427; color: #fff;">
                                        <i class="sym sym-building-03-solid"></i>
                                    </div>
                                    <div>
                                        <h6 class="dash-section-title mb-0">Lokasi</h6>
                                        <span class="dash-section-subtitle">Penempatan aset di setiap lokasi</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 d-flex flex-column p-2" style="min-height: 300px;">
                                    <div class="table-responsive flex-grow-1" style="max-height: 320px; overflow: auto;">
                                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                            <thead class="sticky-top">
                                                <tr style="background: #f8f9fa;">
                                                    <th style="min-width: 36px; width: 36px; border-radius: 8px 0 0 8px;">No
                                                    </th>
                                                    <th style="min-width: 250px;">Lokasi</th>
                                                    <th style="min-width: 100px; border-radius: 0 8px 8px 0;">Jumlah Aset</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($pagedLocations->isEmpty())
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted py-4">
                                                            <i class="sym sym-inbox fs-3 d-block mb-2 text-secondary"></i>
                                                            Belum ada lokasi dengan aset.
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($pagedLocations as $location)
                                                        <tr>
                                                            <td class="text-muted">
                                                                {{ ($pagedLocations->currentPage() - 1) * $pagedLocations->perPage() + $loop->iteration }}
                                                            </td>
                                                            <td class="fw-semibold">
                                                                {{ $location->lokasi ?? 'Tidak diketahui' }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1"
                                                                    style="border-radius: 6px;">{{ $location->total_assets }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <nav aria-label="Location pagination" class="mt-auto pt-2">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @php
                                                $currentPage = $pagedLocations->currentPage();
                                                $lastPage = $pagedLocations->lastPage();
                                            @endphp
                                            <li class="page-item {{ $pagedLocations->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $pagedLocations->previousPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-left"></i>
                                                </a>
                                            </li>
                                            @for ($page = 1; $page <= 3 && $page <= $lastPage; $page++)
                                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $pagedLocations->url($page) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $page }}</a>
                                                </li>
                                            @endfor
                                            @if ($lastPage > 4)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            @if ($lastPage > 3)
                                                <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $pagedLocations->url($lastPage) }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">{{ $lastPage }}</a>
                                                </li>
                                            @endif
                                            <li class="page-item {{ $pagedLocations->onLastPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $pagedLocations->nextPageUrl() }}{{ request('perPage') ? '&perPage=' . request('perPage') : '' }}">
                                                    <i class="sym sym-arrow-narrow-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <a href="{{ route('location.index') }}" class="btn btn-primary mt-2 w-100 fw-semibold"
                                        style="border-radius: 10px;">
                                        Lihat Detail <i class="sym sym-arrow-narrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endcan

            @can('manager')
                {{-- Ajukan Permintaan Aset --}}
                <div class="mb-2">
                    <h5 class="fw-semibold mb-1">Ajukan Permintaan Aset</h5>
                    <p class="text-muted mb-3">
                        Ajukan kebutuhan perangkat atau aset baru untuk menunjang pekerjaan karyawan.
                    </p>

                    <div class="dash-card shadow-sm bg-white">
                        <div class="card-body p-4">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start p-3 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border: 1px solid rgba(99, 102, 241, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #39539D; color: #fff;">
                                            <i class="sym sym-plus-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-2">Pengajuan Aset Baru</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                Permintaan perangkat baru yang dibutuhkan untuk menunjang pekerjaan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start p-3 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid rgba(139, 92, 246, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #6c757d; color: #fff;">
                                            <i class="sym sym-switch-horizontal"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-2">Perubahan Aset</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                Ajukan perubahan pada aset yang digunakan oleh karyawan jika terdapat
                                                kendala atau perlu penyesuaian.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('aset-request.my-requests') }}" class="btn btn-primary fw-semibold"
                                    style="border-radius: 10px;">
                                    Ajukan Permintaan Aset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Proses Pengajuan --}}
                <div class="mb-3">
                    <div class="dash-card shadow-sm bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-2">Cara Pengajuan</h5>
                            <p class="text-muted mb-4">
                                Ikuti langkah-langkah berikut untuk mengajukan permintaan aset dengan mudah.
                            </p>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 rounded-4"
                                        style="background: linear-gradient(135deg, rgba(132, 180, 251, 0.15) 0%, rgba(132, 180, 251, 0.05) 100%); border: 1px solid rgba(13, 110, 253, 0.15) !important;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span
                                                    class="badge rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                    style="width: 36px; height: 36px; font-size: 1.1rem; font-weight: 600;">1</span>
                                                <h6 class="mb-0 fw-semibold text-dark">Pilih Jenis Permintaan</h6>
                                            </div>
                                            <p class="text-muted mb-0 fs-6">
                                                Tentukan apakah Anda ingin menambah atau mengubah aset untuk karyawan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 rounded-4"
                                        style="background: linear-gradient(135deg, rgba(236, 207, 119, 0.15) 0%, rgba(236, 207, 119, 0.05) 100%); border: 1px solid rgba(255, 193, 7, 0.2) !important;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span
                                                    class="badge rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-3"
                                                    style="width: 36px; height: 36px; font-size: 1.1rem; font-weight: 600;">2</span>
                                                <h6 class="mb-0 fw-semibold text-dark">Lengkapi Formulir</h6>
                                            </div>
                                            <p class="text-muted mb-0 fs-6">
                                                Isi detail pengajuan secara lengkap agar dapat diproses dengan baik.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 rounded-4"
                                        style="background: linear-gradient(135deg, rgba(74, 183, 132, 0.15) 0%, rgba(74, 183, 132, 0.05) 100%); border: 1px solid rgba(25, 135, 84, 0.2) !important;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span
                                                    class="badge rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                    style="width: 36px; height: 36px; font-size: 1.1rem; font-weight: 600;">3</span>
                                                <h6 class="mb-0 fw-semibold text-dark">Menunggu Persetujuan</h6>
                                            </div>
                                            <p class="text-muted mb-0 fs-6">
                                                Setelah dikirim, tunggu informasi hasil dari tim terkait.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('finance')
                <div class="mb-4">
                    <div class="dash-card shadow-sm bg-white">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-1">Laporan Penyusutan Aset</h5>
                                <p class="text-muted mb-0">
                                    Total nilai penyusutan keseluruhan dan ringkasan penyusutan aset tahun {{ now()->year }}
                                    (data sampai tahun berjalan).
                                </p>
                            </div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-4 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border: 1px solid rgba(99, 102, 241, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #39539D; color: #fff;">
                                            <i class="sym sym-wallet"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-1">Total Penyusutan Keseluruhan</h6>
                                            <p class="fs-5 fw-bold mb-1">
                                                Rp {{ number_format($totalPenyusutanKeseluruhan, 0, ',', '.') }}
                                            </p>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                Nilai penyusutan sampai tahun {{ now()->year }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $percentChange =
                                            $penyusutanTahunLalu > 0
                                                ? (($penyusutanTahunIni - $penyusutanTahunLalu) /
                                                        $penyusutanTahunLalu) *
                                                    100
                                                : 0;
                                        $absPercent = abs(round($percentChange, 2));
                                        $absChange = abs($penyusutanTahunIni - $penyusutanTahunLalu);
                                        $isIncrease = $percentChange > 0;
                                        $isDecrease = $percentChange < 0;
                                    @endphp
                                    <div class="d-flex align-items-center p-4 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid rgba(139, 92, 246, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #6c757d; color: #fff;">
                                            @if ($isIncrease)
                                                <i class="sym sym-arrow-up"></i>
                                            @elseif ($isDecrease)
                                                <i class="sym sym-arrow-down"></i>
                                            @else
                                                <i class="sym sym-minus"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-1">Nilai Penyusutan Tahun
                                                {{ now()->year }}</h6>
                                            <p class="fs-5 fw-bold mb-1">
                                                Rp {{ number_format($penyusutanTahunIni, 0, ',', '.') }}
                                            </p>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                @if ($isIncrease)
                                                    Naik Rp {{ number_format($absChange, 0, ',', '.') }} (&#x25B2;
                                                    {{ $absPercent }}%) dibanding tahun lalu
                                                @elseif ($isDecrease)
                                                    Turun Rp {{ number_format($absChange, 0, ',', '.') }} (&#x25BC;
                                                    {{ $absPercent }}%) dibanding tahun lalu
                                                @else
                                                    Stabil dibanding tahun lalu
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-center mb-3 p-3 rounded-4"
                                style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.08) 0%, rgba(13, 110, 253, 0.03) 100%); border: 1px solid rgba(13, 110, 253, 0.15);">
                                <i class="sym sym-info-circle text-primary fs-5 flex-shrink-0"></i>
                                <div class="flex-grow-1 text-primary fw-semibold" style="font-size: 0.9rem;">
                                    Ingin analisis lebih lanjut? Ekspor laporan penyusutan aset berdasarkan filter bulan,
                                    tahun, dan jenis aset dengan sekali klik.
                                </div>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('report.depreciation') }}" class="btn btn-primary fw-semibold"
                                    style="border-radius: 10px;">
                                    Export Excel Laporan Penyusutan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('akses-karyawan-finance')
                <div class="mb-4">
                    <h5 class="fw-semibold mb-1">Monitoring Permintaan Aset</h5>
                    <p class="text-muted mb-3">
                        Anda dapat memantau status permintaan aset yang diajukan oleh Manager untuk kebutuhan operasional
                        tim. Pengajuan aset hanya dapat dilakukan oleh Manager.
                    </p>

                    <div class="dash-card shadow-sm bg-white">
                        <div class="card-body p-4">
                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start p-3 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border: 1px solid rgba(99, 102, 241, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #39539D; color: #fff;">
                                            <i class="sym sym-plus-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-2">Pengajuan Aset Baru</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                Permintaan perangkat baru yang dibutuhkan untuk menunjang pekerjaan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start p-3 rounded-4 h-100"
                                        style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid rgba(139, 92, 246, 0.1);">
                                        <div class="dash-stat-icon flex-shrink-0 me-3"
                                            style="background: #6c757d; color: #fff;">
                                            <i class="sym sym-switch-horizontal"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-2">Perubahan Aset</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                Permintaan perubahan pada aset yang sudah ada sesuai kebutuhan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info alert-dismissible fade show d-flex gap-2 align-items-center mb-4"
                                role="alert" style="border-radius: 12px;">
                                <i class="sym sym-info-circle text-primary fs-5"></i>
                                <div class="d-block flex-grow-1">
                                    Pengajuan aset hanya dapat dilakukan oleh <strong>Manager</strong>. Anda tetap dapat
                                    memantau seluruh proses dan status pengajuan di aplikasi ini.
                                </div>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('aset-request.my-requests') }}" class="btn btn-primary fw-semibold"
                                    style="border-radius: 10px;">
                                    Lihat Daftar Permintaan Aset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('akses-karyawan-manager-finance')
                @php
                    $dokumenTtd = [
                        [
                            'title' => 'BAST Serah Terima',
                            'count' => $bast,
                            'route' => route('daftar-tanda-tangan.bast'),
                            'bg' => 'linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%)',
                            'icon' => 'sym sym-file-check-solid',
                            'icon_color' => '#39539D',
                        ],
                        [
                            'title' => 'BAST Pengembalian',
                            'count' => $pengembalian,
                            'route' => route('daftar-tanda-tangan.bastPengembalian'),
                            'bg' => 'linear-gradient(135deg, #fef9c3 0%, #fef3c7 100%)',
                            'icon' => 'sym sym-file-check-solid',
                            'icon_color' => '#ca8a04',
                        ],
                        [
                            'title' => 'Form Pemeliharaan Aset',
                            'count' => $pemeliharaan,
                            'route' => route('daftar-tanda-tangan.maintenance'),
                            'bg' => 'linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%)',
                            'icon' => 'sym sym-file-check-solid',
                            'icon_color' => '#dc3545',
                        ],
                    ];
                @endphp

                <div class="mb-5">
                    <h5 class="fw-semibold mb-1">Tanda Tangan Dokumen</h5>
                    <p class="text-muted mb-3">Berikut adalah dokumen yang menunggu tanda tangan Anda.</p>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        @foreach ($dokumenTtd as $dok)
                            <div class="col">
                                <div class="dash-card shadow-sm h-100" style="background: {{ $dok['bg'] }};">
                                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="dash-stat-icon"
                                                    style="background: {{ $dok['icon_color'] }}; color: #fff;">
                                                    <i class="{{ $dok['icon'] }}"></i>
                                                </div>
                                                <h6 class="fw-semibold mb-0">{{ $dok['title'] }}</h6>
                                            </div>
                                            <h2 class="fw-bold fs-1 mb-4" style="line-height: 1">{{ $dok['count'] }}
                                            </h2>
                                        </div>
                                        <a href="{{ $dok['route'] }}"
                                            class="btn btn-outline-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2"
                                            style="border-radius: 10px;">
                                            Lihat Dokumen <i class="sym sym-arrow-narrow-right fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endcan
    </main>

@section('footer')
    <p></p>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Asset Status Doughnut Chart
    var ctx = document.getElementById('assetStatusChart');
    if (ctx) {
        var chart = new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($statusCounts)),
                datasets: [{
                    data: @json(array_values($statusCounts)),
                    backgroundColor: [
                        '#39539D', '#ED2427', '#5FA3D4', '#98D0F0', '#15A85A', '#FFD700', '#808897'
                    ],
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyleWidth: 10,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }

    // Ticket Trend Line Chart
    var ticketTrendCtx = document.getElementById('ticketTrendChart');
    if (ticketTrendCtx) {
        var trendData = @json($ticketRecap['trend']);
        var trendLabels = trendData.map(function(item) {
            var parts = item.bulan.split('-');
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return months[parseInt(parts[1]) - 1] + ' ' + parts[0].substring(2);
        });
        var trendValues = trendData.map(function(item) {
            return item.total;
        });

        new Chart(ticketTrendCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Jumlah Tiket',
                    data: trendValues,
                    borderColor: '#39539D',
                    backgroundColor: 'rgba(57, 83, 157, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#39539D',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // Jenis Perangkat Maintenance Bar Chart
    var jenisPerangkatCtx = document.getElementById('jenisPerangkatChart');
    if (jenisPerangkatCtx) {
        var jenisData = @json($ticketRecap['jenis_perangkat']);
        var jenisLabels = Object.keys(jenisData);
        var jenisValues = Object.values(jenisData);

        new Chart(jenisPerangkatCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: jenisLabels,
                datasets: [{
                    label: 'Jumlah Maintenance',
                    data: jenisValues,
                    backgroundColor: [
                        'rgba(57, 83, 157, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(244, 63, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(20, 184, 166, 0.8)',
                    ],
                    borderColor: [
                        'rgba(57, 83, 157, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(99, 102, 241, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(236, 72, 153, 1)',
                        'rgba(244, 63, 94, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(20, 184, 166, 1)',
                    ],
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.x + ' tiket';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11 }, stepSize: 1, precision: 0 }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }
</script>

<script>
    function updateItemsPerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
</script>

@endsection
