<style>
    /* ── Google Font ── */
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --sb-width: 268px;
        --sb-collapsed-width: 68px;
        --sb-header-height: 0px;
        --sb-bg: #ffffff;
        --sb-surface: #181b24;
        --sb-border: rgba(255, 255, 255, .06);
        --sb-text: #464c5c;
        --sb-text-muted: #5a6178;
        --sb-active-bg: #1317f426;
        --sb-active-text: #0f6bf5bd;
        --sb-active-border: #0f6af5;
        --sb-hover-bg: rgba(255, 255, 255, .04);
        --sb-section-label: #3d4260;
        --sb-accent: #0f6af5;
        --sb-radius: 10px;
        --sb-transition: .25s cubic-bezier(.4, 0, .2, 1);
    }

    .qn-sidebar {
        font-family: 'DM Sans', sans-serif;
        width: var(--sb-width) !important;
        min-width: var(--sb-width);
        background: var(--sb-bg);
        border-right: 1px solid var(--sb-border) !important;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        transition: width var(--sb-transition), min-width var(--sb-transition);
    }

    #sidebar {
        height: 100%;
        z-index: 1020;
        will-change: width, min-width;
    }

    .qn-sidebar .sb-inner {
        padding: 12px 10px 80px;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .sb-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 10px 20px;
        border-bottom: 1px solid var(--sb-border);
        margin-bottom: 8px;
    }

    .sb-brand-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .sb-brand-icon svg {
        width: 16px;
        height: 16px;
        color: #fff;
    }

    .sb-brand-name {
        font-size: 13px;
        font-weight: 600;
        color: #e2e8f0;
        letter-spacing: .3px;
        line-height: 1.2;
    }

    .sb-brand-sub {
        font-size: 10.5px;
        color: var(--sb-text-muted);
        font-weight: 400;
    }

    .sb-section-label {
        font-family: 'DM Mono', monospace;
        font-size: 9.5px;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: var(--sb-section-label);
        padding: 6px;
        font-weight: 500;
    }

    .sb-item {
        border-radius: var(--sb-radius);
        overflow: hidden;
    }

    .sb-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 8px;
        border-radius: var(--sb-radius);
        color: var(--sb-text);
        text-decoration: none;
        font-size: 14px;
        font-weight: 400;
        transition: background var(--sb-transition), color var(--sb-transition);
        position: relative;
        cursor: pointer;
        user-select: none;
    }

    .sb-link:hover {
        background: var(--sb-hover-bg);
        color: #e2e8f0;
    }

    .sb-link.active {
        background: var(--sb-active-bg);
        color: var(--sb-active-text);
        font-weight: 500;
    }

    .sb-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 3px;
        border-radius: 0 3px 3px 0;
        background: var(--sb-active-border);
    }

    .sb-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        background: rgba(255, 255, 255, .04);
        transition: background var(--sb-transition);
    }

    .sb-link.active .sb-icon {
        background: rgba(99, 102, 241, .2);
    }

    .sb-icon svg {
        width: 14px;
        height: 14px;
    }

    .sb-chevron {
        margin-left: auto;
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        transition: transform var(--sb-transition);
        color: var(--sb-text-muted);
    }

    .sb-link[aria-expanded="true"] .sb-chevron {
        transform: rotate(90deg);
    }

    .sb-sub {
        margin: 2px 0 4px 18px;
        padding-left: 18px;
        border-left: 1px solid var(--sb-border);
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .sb-sub-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 8px;
        border-radius: 7px;
        color: var(--sb-text-muted);
        text-decoration: none;
        font-size: 12.5px;
        transition: background var(--sb-transition), color var(--sb-transition);
    }

    .sb-sub-link:hover {
        background: var(--sb-hover-bg);
        color: #e2e8f0;
    }

    .sb-sub-link.active {
        color: var(--sb-active-text);
        background: rgba(99, 102, 241, .1);
    }

    .sb-sub-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--sb-text-muted);
        flex-shrink: 0;
        transition: background var(--sb-transition);
    }

    .sb-sub-link.active .sb-sub-dot,
    .sb-sub-link:hover .sb-sub-dot {
        background: var(--sb-accent);
    }

    .sb-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
        background: rgba(99, 102, 241, .2);
        color: var(--sb-active-text);
        font-family: 'DM Mono', monospace;
    }

    .sb-divider {
        height: 1px;
        background: var(--sb-border);
        margin: 2px 2px;
    }

    .qn-sidebar-toggle .btn {
        background: var(--sb-bg) !important;
        border-color: var(--sb-border) !important;
        color: var(--sb-text);
        width: 34px;
        height: 34px;
        padding: 0;
        display: grid;
        place-items: center;
        box-shadow: 2px 0 12px rgba(0, 0, 0, .4);
    }

    #mobileSidebar {
        background: var(--sb-bg) !important;
        border-right: 1px solid var(--sb-border) !important;
        width: var(--sb-width) !important;
    }

    .qn-sidebar::-webkit-scrollbar,
    #mobileSidebar .offcanvas-body::-webkit-scrollbar {
        width: 4px;
    }

    .qn-sidebar::-webkit-scrollbar-track,
    #mobileSidebar .offcanvas-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .qn-sidebar::-webkit-scrollbar-thumb,
    #mobileSidebar .offcanvas-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .08);
        border-radius: 4px;
    }

    .sb-collapse {
        overflow: hidden;
    }

    .sb-toggle-wrapper {
        display: flex;
        justify-content: flex-end;
        padding: 8px 10px 2px;
        position: sticky;
        top: 0;
        z-index: 2;
        background: var(--sb-bg);
    }

    .sb-toggle-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: all var(--sb-transition);
        color: #64748b;
        flex-shrink: 0;
        padding: 0;
    }

    .sb-toggle-btn:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .sb-toggle-icon {
        width: 16px;
        height: 16px;
        transition: transform var(--sb-transition);
    }

    .qn-sidebar.sb-collapsed {
        width: var(--sb-collapsed-width) !important;
        min-width: var(--sb-collapsed-width);
    }

    .qn-sidebar.sb-collapsed .sb-inner {
        padding: 8px 6px 80px;
    }

    .qn-sidebar.sb-collapsed .sb-toggle-wrapper {
        justify-content: center;
        padding: 10px 6px 2px;
    }

    .qn-sidebar.sb-collapsed .sb-toggle-icon {
        transform: rotate(180deg);
    }

    .qn-sidebar.sb-collapsed .sb-section-label {
        font-size: 0;
        line-height: 0;
        height: 8px;
        padding: 0;
        margin: 4px 6px;
        overflow: hidden;
        border-bottom: 1px solid #e9ecef;
    }

    .qn-sidebar.sb-collapsed .sb-link {
        justify-content: center;
        padding: 10px 0;
    }

    .qn-sidebar.sb-collapsed .sb-link-text,
    .qn-sidebar.sb-collapsed .sb-badge,
    .qn-sidebar.sb-collapsed .sb-chevron {
        display: none !important;
    }

    .qn-sidebar.sb-collapsed .sb-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
    }

    .qn-sidebar.sb-collapsed .sb-collapse,
    .qn-sidebar.sb-collapsed .sb-sub {
        display: none !important;
    }

    .qn-sidebar.sb-collapsed .sb-divider {
        margin: 4px 6px;
    }

    .qn-sidebar.sb-collapsed .sb-link.active::before {
        top: 25%;
        bottom: 25%;
    }

    .qn-sidebar-toggle {
        top: calc(var(--sb-header-height, 80px) + 8px) !important;
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .qn-sidebar:not(.sb-force-expanded) {
            width: var(--sb-collapsed-width) !important;
            min-width: var(--sb-collapsed-width);
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-inner {
            padding: 8px 6px 80px;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-toggle-wrapper {
            justify-content: center;
            padding: 10px 6px 2px;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-toggle-icon {
            transform: rotate(180deg);
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-section-label {
            font-size: 0;
            line-height: 0;
            height: 8px;
            padding: 0;
            margin: 4px 6px;
            overflow: hidden;
            border-bottom: 1px solid #e9ecef;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-link {
            justify-content: center;
            padding: 10px 0;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-link-text,
        .qn-sidebar:not(.sb-force-expanded) .sb-badge,
        .qn-sidebar:not(.sb-force-expanded) .sb-chevron {
            display: none !important;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-collapse,
        .qn-sidebar:not(.sb-force-expanded) .sb-sub {
            display: none !important;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-divider {
            margin: 4px 6px;
        }

        .qn-sidebar:not(.sb-force-expanded) .sb-link.active::before {
            top: 25%;
            bottom: 25%;
        }
    }
</style>

@php
    $currentRoute = request()->route()?->getName() ?? '';

    $userRole = auth()->check() ? auth()->user()->role : null;

    $normalizedRole = auth()->check()
        ? strtolower(str_replace(['-', ' '], '_', trim((string) auth()->user()->role)))
        : null;

    $isAuditAdmin = auth()->check() && in_array($normalizedRole, [
        'admin',
        'super_admin',
        'superadmin',
    ], true);

    $canAccessInternalNote = auth()->check() && in_array($normalizedRole, [
        'super_admin',
        'superadmin',
        'admin',
        'manager',  
    ], true);

    $menu = [
        [
            'label' => 'Dashboard',
            'section' => true,
            'items' => [
                [
                    'title' => 'Dashboard',
                    'route' => route('dashboard.dashboard'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'dashboard.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Manajemen Aset',
            'section' => true,
            'items' => [
                [
                    'title' => 'Daftar Aset',
                    'route' => '#',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>',
                    'badge' => null,
                    'active' => false,
                    'sub' => [
                        ['title' => 'End User Aset', 'route' => '/end-user-aset', 'active' => false],
                        ['title' => 'Office Aset', 'route' => '/office-aset', 'active' => false],
                        ['title' => 'Physical Host Aset', 'route' => '/physical-host-aset', 'active' => false],
                        ['title' => 'Security Peripheral', 'route' => '/security-peripheral', 'active' => false],
                    ],
                ],
                [
                    'title' => 'Aset Pribadi Pegawai',
                    'route' => route('aset-pribadi.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'aset-pribadi.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Aset Hibah',
                    'route' => route('aset-hibah.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'aset-hibah.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Sparepart',
            'section' => true,
            'items' => [
                [
                    'title' => 'Daftar Sparepart',
                    'route' => route('jenis-sparepart.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'jenis-sparepart.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Berita Acara & Formulir',
            'section' => true,
            'items' => [
                [
                    'title' => 'Berita Acara',
                    'route' => '#',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
                    'badge' => null,
                    'active' => false,
                    'sub' => [
                        ['title' => 'BA Serah Terima', 'route' => '/bast-aset', 'active' => false],
                        ['title' => 'BA Pengembalian Aset', 'route' => '/bast-pengembalian', 'active' => false],
                        ['title' => 'BA Bukti Pembelian', 'route' => '/babp', 'active' => false],
                        ['title' => 'BA Persetujuan Aset Pribadi', 'route' => '/bast-persetujuan-asetpribadi', 'active' => false],
                    ],
                ],
                [
                    'title' => 'Instalasi Aset',
                    'route' => route('instalasi-aset.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'instalasi-aset.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Pemeliharaan Aset',
            'section' => true,
            'items' => [
                [
                    'title' => 'Pemeliharaan Aset',
                    'route' => route('aset-maintenance.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'aset-maintenance.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Aset IT Operasional',
                    'route' => route('aset-maintenance-operasional.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'aset-maintenance-operasional.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Aset Tidak Normal',
                    'route' => route('abnormal-aset.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'abnormal-aset.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Stock Opname',
                    'route' => \Illuminate\Support\Facades\Route::has('stock-opnames.index') ? route('stock-opnames.index') : '#',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M4.5 6.75A2.25 2.25 0 016.75 4.5h10.5A2.25 2.25 0 0119.5 6.75v10.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 17.25V6.75z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'stock-opnames.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Permintaan Aset',
            'section' => true,
            'items' => [
                [
                    'title' => 'Daftar Permintaan Aset',
                    'route' => '#',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
                    'badge' => null,
                    'active' => false,
                    'sub' => [
                        ['title' => 'Permintaan Aset', 'route' => '/aset-request', 'active' => false],
                        ['title' => 'Permintaan Aset Pribadi', 'route' => '/aset-pribadi-request', 'active' => false],
                        ['title' => 'Ajukan Permintaan', 'route' => '/aset-request/my-requests', 'active' => false],
                    ],
                ],
            ],
        ],

        [
            'label' => 'Pemusnahan Aset',
            'section' => true,
            'items' => [
                [
                    'title' => 'Pemusnahan Aset',
                    'route' => route('pemusnahan-aset.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'pemusnahan-aset.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Knowledge Base',
            'section' => true,
            'items' => [
                [
                    'title' => 'Knowledge Base',
                    'route' => route('knowledge-base.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'knowledge-base.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Data Master',
            'section' => true,
            'items' => [
                [
                    'title' => 'Jenis Aset',
                    'route' => route('jenis-aset.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'jenis-aset.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Klasifikasi Laptop',
                    'route' => route('klasifikasi-laptop.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'klasifikasi-laptop.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Lokasi',
                    'route' => route('location.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'location.'),
                    'sub' => [],
                ],
            ],
        ],

        [
            'label' => 'Pengaturan',
            'section' => true,
            'items' => [
                [
                    'title' => 'Pegawai',
                    'route' => route('users.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'users.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Hak Akses',
                    'route' => route('permissions.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'permissions.'),
                    'sub' => [],
                ],
                [
                    'title' => 'Automation IP',
                    'route' => 'http://192.168.11.13/mikrotik',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.633c0-1.806-1.343-3.27-3-3.27s-3 1.464-3 3.27c0 1.152.26 2.243.723 3.218A6.483 6.483 0 0012 20.318a6.483 6.483 0 005.277-2.467A5.972 5.972 0 0018 10.633z"/>',
                    'badge' => null,
                    'active' => false,
                    'sub' => [],
                ],
                [
                    'title' => 'Nomor Template',
                    'route' => route('numbering-template.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'numbering-template.'),
                    'sub' => [],
                ],
            ],
        ],
    ];

    if ($canAccessInternalNote && \Illuminate\Support\Facades\Route::has('internal-notes.index')) {
    foreach ($menu as &$section) {
        if (($section['label'] ?? null) === 'Pemeliharaan Aset') {
            $section['items'][] = [
                'title' => 'Catatan Internal Tim',
                'route' => route('internal-notes.index'),
                'icon' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h4.5M6.75 3h10.5A2.25 2.25 0 0119.5 5.25v13.5A2.25 2.25 0 0117.25 21H6.75A2.25 2.25 0 014.5 18.75V5.25A2.25 2.25 0 016.75 3z"/>',
                'badge' => null,
                'active' => str_starts_with($currentRoute, 'internal-notes.'),
                'sub' => [],
            ];

            break;
        }
    }

    unset($section);
    }

    if (auth()->check() && $normalizedRole === 'super_admin') {
        $menu[] = [
            'label' => 'Feedback User',
            'section' => true,
            'items' => [
                [
                    'title' => 'Feedback',
                    'route' => route('reviews.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h-3m0 0h3m-3 0v3m0-3v-3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'reviews.'),
                    'sub' => [],
                ],
            ],
        ];

        $menu[] = [
            'label' => 'Manajemen Company',
            'section' => true,
            'items' => [
                [
                    'title' => 'Company',
                    'route' => route('company-settings.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'company-settings.'),
                    'sub' => [],
                ],
            ],
        ];
    }

        if ($isAuditAdmin && \Illuminate\Support\Facades\Route::has('software-licenses.index')) {
        $menu[] = [
            'label' => 'License & Software',
            'section' => true,
            'items' => [
                [
                    'title' => 'Management License & Software',
                    'route' => route('software-licenses.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M6.75 3.75h10.5A2.25 2.25 0 0119.5 6v12A2.25 2.25 0 0117.25 20.25H6.75A2.25 2.25 0 014.5 18V6A2.25 2.25 0 016.75 3.75z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'software-licenses.'),
                    'sub' => [],
                ],
            ],
        ];
    }

        if ($isAuditAdmin && \Illuminate\Support\Facades\Route::has('asset-offer-requests.index')) {
        $menu[] = [
            'label' => 'Penawaran Aset',
            'section' => true,
            'items' => [
                [
                    'title' => 'Penawaran Aset',
                    'route' => route('asset-offer-requests.index'),
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75A2.25 2.25 0 016.75 4.5h10.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V6.75z"/>',
                    'badge' => null,
                    'active' => str_starts_with($currentRoute, 'asset-offer-requests.')
                        || str_starts_with($currentRoute, 'asset-vendors.')
                        || str_starts_with($currentRoute, 'asset-vendor-offers.'),
                    'sub' => [
                        [
                            'title' => 'Kebutuhan Aset',
                            'route' => route('asset-offer-requests.index'),
                            'active' => str_starts_with($currentRoute, 'asset-offer-requests.')
                                && !request()->routeIs('asset-offer-requests.history'),
                        ],
                        [
                            'title' => 'List Vendor',
                            'route' => route('asset-vendors.index'),
                            'active' => str_starts_with($currentRoute, 'asset-vendors.'),
                        ],
                        [
                            'title' => 'History Pengadaan',
                            'route' => route('asset-offer-requests.history'),
                            'active' => request()->routeIs('asset-offer-requests.history'),
                        ],
                    ],
                ],
            ],
        ];
    }

    if ($isAuditAdmin) {
    $monitoringItems = [];

    if (\Illuminate\Support\Facades\Route::has('report-updates.index')) {
        $monitoringItems[] = [
            'title' => 'Laporan Update',
            'route' => route('report-updates.index'),
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25h6M9 12.75h6M9 8.25h6M5.25 3.75h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25z"/>',
            'badge' => null,
            'active' => str_starts_with($currentRoute, 'report-updates.'),
            'sub' => [],
        ];
    }

    if (\Illuminate\Support\Facades\Route::has('audit-trails.index')) {
        $monitoringItems[] = [
            'title' => 'Audit Trail',
            'route' => route('audit-trails.index'),
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2.25 5.25H6.75A2.25 2.25 0 014.5 19V5A2.25 2.25 0 016.75 2.75h7.19a2.25 2.25 0 011.59.66l2.56 2.56a2.25 2.25 0 01.66 1.59V19A2.25 2.25 0 0117.25 21.25z"/>',
            'badge' => null,
            'active' => str_starts_with($currentRoute, 'audit-trails.'),
            'sub' => [],
        ];
    }

    if (!empty($monitoringItems)) {
        $menu[] = [
            'label' => 'Monitoring',
            'section' => true,
            'items' => $monitoringItems,
        ];
    }
}
@endphp

<aside class="qn-sidebar d-none d-lg-flex flex-column border-end" id="sidebar" style="z-index: 0;">
    <div class="sb-toggle-wrapper">
        <button class="sb-toggle-btn" id="sidebarToggleDesktop" type="button" title="Toggle sidebar">
            <svg class="sb-toggle-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
    </div>
    <div class="sb-inner">
        @include('layouts.sidebar-menu', ['menu' => $menu, 'prefix' => 'desktop'])
    </div>
</aside>

<aside class="qn-sidebar offcanvas offcanvas-start d-lg-none" data-bs-scroll="false" tabindex="-1" id="mobileSidebar"
    style="z-index: 1050;">
    <div class="offcanvas-body p-0">
        <div class="sb-inner">
            @include('layouts.sidebar-menu', ['menu' => $menu, 'prefix' => 'mobile'])
        </div>
    </div>
</aside>

<div class="qn-sidebar-toggle position-fixed d-block d-lg-none" style="z-index: 1040;">
    <button type="button" class="btn btn-sm rounded-end-3 rounded-start-0 border-start-0" data-bs-toggle="offcanvas"
        data-bs-target="#mobileSidebar" aria-label="Toggle sidebar menu">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('sidebar');
        var toggleBtn = document.getElementById('sidebarToggleDesktop');
        var header = document.querySelector('.qn-header');
        var storageKey = 'itam-sb-collapsed';

        function updateHeaderHeight() {
            if (header) {
                var h = header.offsetHeight;
                document.documentElement.style.setProperty('--sb-header-height', h + 'px');
            }
        }
        updateHeaderHeight();
        window.addEventListener('resize', updateHeaderHeight);

        if (!sidebar || !toggleBtn) return;

        var savedState = localStorage.getItem(storageKey);
        if (savedState === 'true') {
            sidebar.classList.add('sb-collapsed');
        }

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sb-collapsed');
            localStorage.setItem(storageKey, sidebar.classList.contains('sb-collapsed'));

            if (window.innerWidth >= 992 && window.innerWidth < 1200) {
                if (!sidebar.classList.contains('sb-collapsed')) {
                    sidebar.classList.add('sb-force-expanded');
                } else {
                    sidebar.classList.remove('sb-force-expanded');
                }
            }
        });

        var mqLarge = window.matchMedia('(min-width: 1200px)');
        mqLarge.addEventListener('change', function(e) {
            if (e.matches) {
                sidebar.classList.remove('sb-force-expanded');
                if (localStorage.getItem(storageKey) === 'true') {
                    sidebar.classList.add('sb-collapsed');
                } else {
                    sidebar.classList.remove('sb-collapsed');
                }
            } else {
                sidebar.classList.remove('sb-force-expanded');
                sidebar.classList.remove('sb-collapsed');
            }
        });
    });
</script>
