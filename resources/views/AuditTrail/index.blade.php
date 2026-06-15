@extends('layouts.admin')

@section('title', ($activeTab ?? 'activity') === 'auth' ? 'Audit Login Logout' : 'Audit Trail')

@section('content')
    @php
        $isAuthTab = ($activeTab ?? 'activity') === 'auth';
        $indexRoute = $isAuthTab ? route('audit-trails.auth') : route('audit-trails.index');
        $resetRoute = $indexRoute;

        $totalLog = (int) ($summary['total'] ?? 0);
        $totalToday = (int) ($summary['today'] ?? 0);

        $totalLogin = (int) (
            $summary['login']
            ?? $summary['total_login']
            ?? ($isAuthTab ? ($summary['workflow'] ?? 0) : 0)
        );

        $totalLogout = (int) (
            $summary['logout']
            ?? $summary['total_logout']
            ?? ($isAuthTab ? max($totalLog - $totalLogin, 0) : 0)
        );
    @endphp

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-2 px-0 mb-2">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="sym sym-home-line"></i> Monitoring</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $isAuthTab ? 'Audit Login Logout' : 'Audit Trail Aktivitas' }}
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
                            <div>
                                <h4 class="m-0">{{ $isAuthTab ? 'Audit Login Logout' : 'Audit Trail Aktivitas' }}</h4>
                                <span class="text-muted">
                                    {{ $isAuthTab ? 'Riwayat user yang login dan logout dari sistem' : 'Riwayat aktivitas data pada sistem ITAM' }}
                                </span>
                            </div>

                            <form method="GET" action="{{ route('audit-trails.export') }}" class="m-0">
                                @if ($isAuthTab)
                                    <input type="hidden" name="auth_tab" value="1">
                                @endif

                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="module" value="{{ request('module') }}">
                                <input type="hidden" name="event" value="{{ request('event') }}">
                                <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                                <input type="hidden" name="perPage" value="{{ request('perPage', 15) }}">

                                <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                                    <i class="sym sym-download-simple"></i>
                                    <span>Export Excel</span>
                                </button>
                            </form>
                        </div>

                        <ul class="nav nav-pills gap-2 mb-3">
                            <li class="nav-item">
                                <a class="nav-link {{ !$isAuthTab ? 'active' : '' }}" href="{{ route('audit-trails.index') }}">
                                    Aktivitas Sistem
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $isAuthTab ? 'active' : '' }}" href="{{ route('audit-trails.auth') }}">
                                    Login / Logout User
                                </a>
                            </li>
                        </ul>

                        <hr>

                        <div class="audit-stat-row mb-4">
                            <div class="{{ $isAuthTab ? 'audit-stat-col-auth' : 'audit-stat-col-activity' }}">
                                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #DFECFF;">
                                    <div class="card-body">
                                        <div class="text-muted small mb-1">Total Log</div>
                                        <div class="fs-3 fw-bold">{{ number_format($totalLog) }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="{{ $isAuthTab ? 'audit-stat-col-auth' : 'audit-stat-col-activity' }}">
                                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #d1ffde;">
                                    <div class="card-body">
                                        <div class="text-muted small mb-1">Hari Ini</div>
                                        <div class="fs-3 fw-bold">{{ number_format($totalToday) }}</div>
                                    </div>
                                </div>
                            </div>

                            @if (!$isAuthTab)
                                <div class="audit-stat-col-activity">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #E8F7FF;">
                                        <div class="card-body">
                                            <div class="text-muted small mb-1">Created</div>
                                            <div class="fs-4 fw-bold">{{ number_format($summary['created'] ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="audit-stat-col-activity">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #FFF4CC;">
                                        <div class="card-body">
                                            <div class="text-muted small mb-1">Updated</div>
                                            <div class="fs-4 fw-bold">{{ number_format($summary['updated'] ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="audit-stat-col-activity">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #F8C9C9;">
                                        <div class="card-body">
                                            <div class="text-muted small mb-1">Deleted</div>
                                            <div class="fs-4 fw-bold">{{ number_format($summary['deleted'] ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="audit-stat-col-auth">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #E8F7FF;">
                                        <div class="card-body">
                                            <div class="text-muted small mb-1">Total Login</div>
                                            <div class="fs-4 fw-bold">{{ number_format($totalLogin) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="audit-stat-col-auth">
                                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #F8C9C9;">
                                        <div class="card-body">
                                            <div class="text-muted small mb-1">Total Logout</div>
                                            <div class="fs-4 fw-bold">{{ number_format($totalLogout) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <form method="GET" action="{{ $indexRoute }}" class="row g-3 mb-4">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label">Pencarian</label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari user, modul, referensi, deskripsi..."
                                    value="{{ request('search') }}">
                            </div>

                            <div class="col-12 col-md-6 col-lg-2">
                                <label class="form-label">Modul</label>
                                <select name="module" class="form-select">
                                    <option value="">Semua Modul</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module }}" {{ request('module') === $module ? 'selected' : '' }}>
                                            {{ $module }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-2">
                                <label class="form-label">Event</label>
                                <select name="event" class="form-select">
                                    <option value="">Semua Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}" {{ request('event') === $event ? 'selected' : '' }}>
                                            {{ $event }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-2">
                                <label class="form-label">User</label>
                                <select name="user_id" class="form-select">
                                    <option value="">Semua User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name_karyawan ?? $user->username ?? $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 col-md-3 col-lg-1">
                                <label class="form-label">Dari</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>

                            <div class="col-6 col-md-3 col-lg-1">
                                <label class="form-label">Sampai</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>

                            <div class="col-12 col-lg-1 d-grid">
                                <label class="form-label d-none d-lg-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>

                            <div class="col-12 d-flex flex-wrap gap-2">
                                <a href="{{ $resetRoute }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle audit-table mb-0">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th style="min-width: 145px;">Waktu</th>
                                        <th style="min-width: 170px;">User</th>
                                        <th style="min-width: 100px;">Role</th>
                                        <th style="min-width: 140px;">Modul</th>
                                        <th style="min-width: 120px;">Event</th>
                                        <th style="min-width: 120px;">Referensi</th>
                                        <th style="min-width: 180px;">Subject</th>
                                        <th style="min-width: 260px;">Deskripsi</th>
                                        <th class="text-center" style="min-width: 90px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($auditTrails as $log)
                                        @php
                                            $badgeClass = match ($log->event) {
                                                'login' => 'bg-success',
                                                'logout' => 'bg-secondary',
                                                'created' => 'bg-success',
                                                'updated',
                                                'maintenance_updated',
                                                'revised',
                                                'reviewed',
                                                'priority_updated' => 'bg-warning text-dark',
                                                'deleted',
                                                'rejected' => 'bg-danger',
                                                'approved',
                                                'started',
                                                'requested',
                                                'assigned',
                                                'maintenance_completed',
                                                'maintenance_signed',
                                                'submitted_finished',
                                                'completed',
                                                'estimated' => 'bg-primary',
                                                'maintenance_pending' => 'bg-secondary',
                                                default => 'bg-dark',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $log->created_at?->format('d-m-Y H:i:s') ?? '-' }}</td>
                                            <td>{{ $log->user->name_karyawan ?? $log->user->username ?? $log->user->email ?? $log->user_name ?? '-' }}</td>
                                            <td>{{ $log->user_role ?? '-' }}</td>
                                            <td>{{ $log->module ?? '-' }}</td>
                                            <td><span class="badge {{ $badgeClass }}">{{ $log->event }}</span></td>
                                            <td>{{ $log->reference_no ?? '-' }}</td>
                                            <td>{{ $log->subject ?? '-' }}</td>
                                            <td class="text-wrap">{{ $log->description ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('audit-trails.show', $log->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                Belum ada data audit trail.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between gap-3 pt-4">
                            <p class="text-dark m-0">
                                Menampilkan
                                <span class="fw-bold">{{ $auditTrails->firstItem() ?? 0 }}</span> -
                                <span class="fw-bold">{{ $auditTrails->lastItem() ?? 0 }}</span>
                                dari Total <span class="fw-bold">{{ $auditTrails->total() }}</span> data
                            </p>

                            <div class="d-flex align-items-center gap-2">
                                <label for="itemsPerPage" class="form-label m-0 text-dark">Tampilkan</label>
                                <select id="itemsPerPage" class="form-select form-select-sm" style="width: auto;"
                                    onchange="updateItemsPerPage(this.value)">
                                    <option value="10" {{ request('perPage', 15) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request('perPage', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            <div>
                                {{ $auditTrails->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .audit-table td,
        .audit-table th {
            vertical-align: middle;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px;
        }

        .audit-stat-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .audit-stat-col-auth {
            flex: 1 1 calc(25% - 16px);
            min-width: 190px;
        }

        .audit-stat-col-activity {
            flex: 1 1 calc(20% - 16px);
            min-width: 190px;
        }

        @media (max-width: 991.98px) {
            .audit-stat-col-auth,
            .audit-stat-col-activity {
                flex: 1 1 calc(50% - 16px);
            }
        }

        @media (max-width: 575.98px) {
            .audit-stat-col-auth,
            .audit-stat-col-activity {
                flex: 1 1 100%;
            }
        }
    </style>

    <script>
        function updateItemsPerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    </script>
@endsection