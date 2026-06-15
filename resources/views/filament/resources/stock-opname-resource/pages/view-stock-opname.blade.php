<x-filament-panels::page>
    @php
        $badgeColor = function (?string $status) {
            return match ($status) {
                'completed', 'sesuai' => 'background:#dcfce7;color:#166534;border-color:#bbf7d0;',
                'need_follow_up', 'perlu_tindak_lanjut', 'tidak_sesuai', 'rusak_ringan' => 'background:#fef3c7;color:#92400e;border-color:#fde68a;',
                'cancelled', 'tidak_ada', 'rusak_berat' => 'background:#fee2e2;color:#991b1b;border-color:#fecaca;',
                'in_progress' => 'background:#dbeafe;color:#1e40af;border-color:#bfdbfe;',
                default => 'background:#f3f4f6;color:#374151;border-color:#e5e7eb;',
            };
        };

        $summary = $summary ?? [];
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <div class="text-sm text-gray-500">{{ $stockOpname->code }}</div>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                        {{ $stockOpname->title }}
                    </h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="rounded-full border px-3 py-1 text-xs font-semibold" style="{{ $badgeColor($stockOpname->status) }}">
                            {{ $statusLabel($stockOpname->status) }}
                        </span>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-600 dark:border-gray-700 dark:text-gray-300">
                            {{ match($stockOpname->scope_type) {
                                'multi_team' => 'Multi Tim',
                                'single_team' => 'Single Tim',
                                'personnel' => 'Personel',
                                'office_asset' => 'Aset Kantor',
                                default => $stockOpname->scope_type,
                            } }}
                        </span>
                        <span class="rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-600 dark:border-gray-700 dark:text-gray-300">
                            PIC: {{ $stockOpname->checker?->name ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm sm:grid-cols-4">
                    <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                        <div class="text-gray-500">Total Item</div>
                        <div class="text-xl font-bold">{{ (int) ($summary['total'] ?? 0) }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                        <div class="text-gray-500">Belum Dicek</div>
                        <div class="text-xl font-bold">{{ (int) ($summary['pending'] ?? 0) }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                        <div class="text-gray-500">Sesuai</div>
                        <div class="text-xl font-bold">{{ (int) ($summary['sesuai'] ?? 0) }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                        <div class="text-gray-500">Tindak Lanjut</div>
                        <div class="text-xl font-bold">{{ (int) ($summary['perlu_tindak_lanjut'] ?? 0) }}</div>
                    </div>
                </div>
            </div>

            @if((int) ($summary['perlu_tindak_lanjut'] ?? 0) > 0)
                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    Ada aset yang membutuhkan tindak lanjut. Catatan tindak lanjut otomatis masuk ke menu Catatan Internal.
                </div>
            @endif
        </div>

        @if($stockOpname->scope_type !== 'office_asset')
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-950 dark:text-white">Target Personel dan Aset</h3>

                @forelse($stockOpname->teams as $team)
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="border-b border-gray-200 p-4 dark:border-gray-800">
                            <div class="text-lg font-semibold">{{ $team->team }}</div>
                            <div class="text-sm text-gray-500">{{ $team->users->count() }} personel</div>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach($team->users as $opnameUser)
                                @php
                                    $user = $opnameUser->user;
                                    $userItems = collect($itemsByUser->get($user?->id, collect()));
                                    $checked = $userItems->where('result_status', '!=', 'pending')->count();
                                    $followUp = $userItems->where('need_follow_up', true)->count();
                                @endphp

                                <details class="group">
                                    <summary class="flex cursor-pointer items-center justify-between gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <div>
                                            <div class="font-semibold text-gray-950 dark:text-white">{{ $user?->name ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $user?->job_title ?: '-' }} • {{ $user?->email ?: '-' }}</div>
                                        </div>
                                        <div class="flex flex-wrap items-center justify-end gap-2 text-xs">
                                            <span class="rounded-full border border-gray-200 px-3 py-1 dark:border-gray-700">{{ $userItems->count() }} aset</span>
                                            <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-blue-700">{{ $checked }} dicek</span>
                                            @if($followUp > 0)
                                                <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">{{ $followUp }} tindak lanjut</span>
                                            @endif
                                        </div>
                                    </summary>

                                    <div class="grid gap-3 p-4 pt-0 md:grid-cols-2 xl:grid-cols-3">
                                        @forelse($userItems as $item)
                                            <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
                                                <div class="text-xs text-gray-500">{{ $item->snapshot_asset_number ?: '-' }}</div>
                                                <div class="mt-1 font-semibold text-gray-950 dark:text-white">{{ $item->snapshot_asset_name ?: 'Aset' }}</div>
                                                <div class="mt-1 text-sm text-gray-500">
                                                    {{ $item->snapshot_asset_brand ?: '-' }} • SN: {{ $item->snapshot_serial_number ?: '-' }}
                                                </div>
                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" style="{{ $badgeColor($item->result_status) }}">
                                                        {{ $statusLabel($item->result_status) }}
                                                    </span>
                                                    <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" style="{{ $badgeColor($item->physical_condition) }}">
                                                        {{ $conditionLabel($item->physical_condition) }}
                                                    </span>
                                                </div>
                                                @if($item->need_follow_up)
                                                    <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 p-2 text-xs text-amber-900">
                                                        Perlu tindak lanjut: {{ $item->follow_up_summary ?: $item->notes ?: 'Belum ada catatan detail.' }}
                                                    </div>
                                                @endif
                                                <div class="mt-4">
                                                    <a href="{{ $itemEditUrl($item) }}"
                                                       class="inline-flex rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white hover:bg-primary-500">
                                                        Opname Aset
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="rounded-xl border border-dashed border-gray-300 p-4 text-sm text-gray-500 dark:border-gray-700">
                                                Belum ada aset untuk personel ini.
                                            </div>
                                        @endforelse
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900">
                        Belum ada tim/personel target. Edit stock opname atau buat ulang sesi dengan cakupan yang benar.
                    </div>
                @endforelse

                @if($stockOpname->teams->isEmpty() && $stockOpname->users->isNotEmpty())
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="mb-4 text-lg font-bold text-gray-950 dark:text-white">Personel Terpilih</h3>
                        <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                            @foreach($stockOpname->users as $opnameUser)
                                @php
                                    $user = $opnameUser->user;
                                    $userItems = collect($itemsByUser->get($user?->id, collect()));
                                @endphp
                                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
                                    <div class="font-semibold">{{ $user?->name ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $user?->team ?: '-' }}</div>
                                    <div class="mt-2 text-xs text-gray-500">{{ $userItems->count() }} aset</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 p-4 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-950 dark:text-white">Aset Kantor</h3>
                    <div class="text-sm text-gray-500">{{ $officeItems->count() }} item pemeriksaan</div>
                </div>

                <div class="grid gap-3 p-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($officeItems as $item)
                        <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
                            <div class="text-xs text-gray-500">{{ $item->snapshot_asset_number ?: '-' }}</div>
                            <div class="mt-1 font-semibold text-gray-950 dark:text-white">{{ $item->snapshot_asset_name ?: 'Aset Kantor' }}</div>
                            <div class="mt-1 text-sm text-gray-500">
                                {{ $item->snapshot_location_name ?: 'Tanpa Lokasi' }}
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" style="{{ $badgeColor($item->result_status) }}">
                                    {{ $statusLabel($item->result_status) }}
                                </span>
                                <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" style="{{ $badgeColor($item->physical_condition) }}">
                                    {{ $conditionLabel($item->physical_condition) }}
                                </span>
                            </div>
                            <div class="mt-4">
                                <a href="{{ $itemEditUrl($item) }}"
                                   class="inline-flex rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white hover:bg-primary-500">
                                    Opname Aset
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 p-4 text-sm text-gray-500 dark:border-gray-700">
                            Belum ada aset kantor tergenerate.
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 p-4 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-950 dark:text-white">Catatan Internal / Tindak Lanjut</h3>
                <div class="text-sm text-gray-500">Catatan yang berasal dari item bermasalah maupun catatan manual yang dikaitkan ke stock opname ini.</div>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($stockOpname->internalNotes as $note)
                    <div class="p-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" style="{{ $badgeColor($note->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $note->status)) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $note->type)) }} • {{ ucfirst($note->priority) }}</span>
                        </div>
                        <div class="mt-2 text-sm text-gray-800 dark:text-gray-200">{{ $note->content }}</div>
                        <div class="mt-1 text-xs text-gray-500">Dibuat oleh: {{ $note->creator?->name ?: '-' }}</div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-gray-500">Belum ada catatan internal.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
