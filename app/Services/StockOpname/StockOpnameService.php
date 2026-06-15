<?php

namespace App\Services\StockOpname;

use App\Models\EndUserAsset;
use App\Models\InternalNote;
use App\Models\OfficeAsset;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use App\Models\StockOpnameTeam;
use App\Models\StockOpnameUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StockOpnameService
{
    public function syncTargetsFromPayload(StockOpname $stockOpname, array $payload): void
    {
        DB::transaction(function () use ($stockOpname, $payload): void {
            $stockOpname->teams()->delete();
            $stockOpname->users()->delete();

            $scope = $payload['scope_type'] ?? $stockOpname->scope_type;

            if ($scope === 'office_asset') {
                $stockOpname->forceFill([
                    'scope_type' => 'office_asset',
                    'type' => 'office_asset',
                ])->save();

                return;
            }

            if ($scope === 'multi_team') {
                $teams = collect($payload['target_team_ids'] ?? [])
                    ->filter()
                    ->unique()
                    ->values();
            } elseif ($scope === 'single_team') {
                $teams = collect([$payload['target_team_id'] ?? null])
                    ->filter()
                    ->unique()
                    ->values();
            } else {
                $teams = collect();
            }

            if ($teams->isNotEmpty()) {
                foreach ($teams as $teamName) {
                    $opnameTeam = StockOpnameTeam::query()->create([
                        'stock_opname_id' => $stockOpname->id,
                        'team' => $teamName,
                    ]);

                    $users = User::query()
                        ->where('status', 'active')
                        ->where('team', $teamName)
                        ->orderBy('name')
                        ->get();

                    foreach ($users as $user) {
                        StockOpnameUser::query()->firstOrCreate([
                            'stock_opname_id' => $stockOpname->id,
                            'user_id' => $user->id,
                        ], [
                            'stock_opname_team_id' => $opnameTeam->id,
                            'team' => $teamName,
                        ]);
                    }
                }

                $stockOpname->forceFill([
                    'scope_type' => $scope,
                    'type' => $scope === 'multi_team' ? 'multi_team' : 'team',
                ])->save();

                return;
            }

            if ($scope === 'personnel') {
                $userIds = collect($payload['target_user_ids'] ?? [])
                    ->map(fn ($id) => (int) $id)
                    ->filter()
                    ->unique()
                    ->values();

                $users = User::query()
                    ->whereIn('id', $userIds)
                    ->orderBy('team')
                    ->orderBy('name')
                    ->get();

                foreach ($users as $user) {
                    StockOpnameUser::query()->firstOrCreate([
                        'stock_opname_id' => $stockOpname->id,
                        'user_id' => $user->id,
                    ], [
                        'stock_opname_team_id' => null,
                        'team' => $user->team,
                    ]);
                }

                $stockOpname->forceFill([
                    'scope_type' => 'personnel',
                    'type' => 'personnel',
                ])->save();
            }
        });
    }

    public function generateItems(StockOpname $stockOpname): int
    {
        return DB::transaction(function () use ($stockOpname): int {
            $created = 0;

            if ($stockOpname->scope_type !== 'office_asset') {
                $userIds = $stockOpname->users()->pluck('user_id')->filter()->unique()->values()->all();

                if (! empty($userIds)) {
                    EndUserAsset::query()
                        ->with(['asset.assetType', 'user'])
                        ->whereIn('user_id', $userIds)
                        ->chunkById(100, function ($rows) use ($stockOpname, &$created): void {
                            foreach ($rows as $row) {
                                $asset = $row->asset;

                                if (! $asset) {
                                    continue;
                                }

                                $item = StockOpnameItem::query()->firstOrCreate([
                                    'stock_opname_id' => $stockOpname->id,
                                    'end_user_asset_id' => $row->id,
                                ], [
                                    'company_id' => $stockOpname->company_id,
                                    'asset_id' => $asset->id,
                                    'user_id' => $row->user_id,
                                    'asset_source' => 'end_user',
                                    'snapshot_asset_number' => $asset->asset_number,
                                    'snapshot_asset_name' => $asset->name,
                                    'snapshot_asset_brand' => $asset->brand,
                                    'snapshot_serial_number' => $asset->serial_number,
                                    'snapshot_user_name' => $row->user?->name,
                                    'snapshot_user_role' => $row->user?->job_title,
                                    'result_status' => 'pending',
                                    'physical_condition' => null,
                                    'user_match' => true,
                                    'need_follow_up' => false,
                                    'checklist_data' => $this->defaultChecklistDataForAsset($asset),
                                ]);

                                if ($item->wasRecentlyCreated) {
                                    $created++;
                                }
                            }
                        });
                }
            }

            if ($stockOpname->scope_type === 'office_asset') {
                OfficeAsset::query()
                    ->with(['asset.assetType', 'location'])
                    ->chunkById(100, function ($rows) use ($stockOpname, &$created): void {
                        foreach ($rows as $row) {
                            $asset = $row->asset;

                            if (! $asset) {
                                continue;
                            }

                            $item = StockOpnameItem::query()->firstOrCreate([
                                'stock_opname_id' => $stockOpname->id,
                                'office_asset_id' => $row->id,
                            ], [
                                'company_id' => $stockOpname->company_id,
                                'asset_id' => $asset->id,
                                'location_id' => $row->location_id,
                                'asset_source' => 'office',
                                'snapshot_asset_number' => $asset->asset_number,
                                'snapshot_asset_name' => $asset->name,
                                'snapshot_asset_brand' => $asset->brand,
                                'snapshot_serial_number' => $asset->serial_number,
                                'snapshot_location_name' => $row->location?->name,
                                'result_status' => 'pending',
                                'physical_condition' => null,
                                'user_match' => true,
                                'need_follow_up' => false,
                                'checklist_data' => $this->defaultChecklistDataForAsset($asset),
                            ]);

                            if ($item->wasRecentlyCreated) {
                                $created++;
                            }
                        }
                    });
            }

            if ($stockOpname->status === 'draft') {
                $stockOpname->forceFill(['status' => 'in_progress'])->save();
            }

            $this->recalculateSummary($stockOpname);

            return $created;
        });
    }

    public function defaultChecklistDataForAsset($asset): array
    {
        $name = mb_strtolower(trim(implode(' ', array_filter([
            $asset?->name,
            $asset?->assetType?->name,
            $asset?->brand,
            $asset?->model,
        ]))));

        $genre = match (true) {
            str_contains($name, 'laptop'), str_contains($name, 'notebook') => 'laptop',
            str_contains($name, 'handphone'), str_contains($name, 'smartphone'), preg_match('/\bhp\b/', $name) === 1 => 'handphone',
            str_contains($name, 'monitor'), str_contains($name, 'display') => 'monitor',
            str_contains($name, 'printer') => 'printer',
            str_contains($name, 'pc'), str_contains($name, 'desktop'), str_contains($name, 'komputer'), str_contains($name, 'cpu') => 'pc',
            default => 'default',
        };

        $items = match ($genre) {
            'laptop' => ['Fisik unit', 'Layar', 'Keyboard', 'Touchpad', 'Charger/adaptor', 'Baterai', 'Serial number', 'Kondisi performa'],
            'handphone' => ['Fisik unit', 'Layar', 'Tombol', 'Kamera', 'Baterai', 'Charger', 'IMEI/serial number', 'Kondisi performa'],
            'monitor' => ['Fisik unit', 'Panel layar', 'Kabel power', 'Kabel display', 'Port display', 'Serial number'],
            'printer' => ['Fisik unit', 'Power', 'Koneksi', 'Hasil cetak', 'Cartridge/toner', 'Serial number'],
            'pc' => ['Fisik unit', 'Power supply', 'Storage', 'RAM', 'Port I/O', 'Sistem operasi', 'Serial number'],
            default => ['Fisik aset', 'Kelengkapan', 'Serial number', 'Lokasi/pemegang', 'Kondisi umum'],
        };

        return collect($items)->map(fn ($label) => [
            'label' => $label,
            'status' => 'baik',
            'notes' => null,
        ])->values()->all();
    }

    public function recalculateSummary(StockOpname $stockOpname): array
    {
        $query = $stockOpname->items();

        $summary = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('result_status', 'pending')->count(),
            'checked' => (clone $query)->whereNotNull('checked_at')->count(),
            'sesuai' => (clone $query)->where('result_status', 'sesuai')->count(),
            'tidak_sesuai' => (clone $query)->where('result_status', 'tidak_sesuai')->count(),
            'tidak_ada' => (clone $query)->where('result_status', 'tidak_ada')->count(),
            'perlu_tindak_lanjut' => (clone $query)->where(function ($q) {
                $q->where('need_follow_up', true)
                    ->orWhere('result_status', 'perlu_tindak_lanjut')
                    ->orWhereIn('physical_condition', ['rusak_ringan', 'rusak_berat']);
            })->count(),
        ];

        $stockOpname->forceFill(['summary' => $summary])->save();

        return $summary;
    }

    public function canComplete(StockOpname $stockOpname): bool
    {
        $summary = $this->recalculateSummary($stockOpname);

        return ((int) ($summary['total'] ?? 0)) > 0
            && ((int) ($summary['pending'] ?? 0)) === 0
            && ((int) ($summary['perlu_tindak_lanjut'] ?? 0)) === 0;
    }

    public function markNeedFollowUpIfNeeded(StockOpname $stockOpname): void
    {
        $summary = $this->recalculateSummary($stockOpname);

        if (((int) ($summary['perlu_tindak_lanjut'] ?? 0)) > 0) {
            $stockOpname->forceFill(['status' => 'need_follow_up'])->save();
        } elseif (((int) ($summary['pending'] ?? 0)) > 0 && $stockOpname->status !== 'completed') {
            $stockOpname->forceFill(['status' => 'in_progress'])->save();
        }
    }

    public function complete(StockOpname $stockOpname): void
    {
        $this->recalculateSummary($stockOpname);

        $stockOpname->forceFill([
            'status' => 'completed',
            'completed_at' => now(),
            'checked_by' => $stockOpname->checked_by ?: auth()->id(),
        ])->save();
    }

    public function syncInternalNoteFromItem(StockOpnameItem $item): void
    {
        $requiresFollowUp = $this->itemRequiresFollowUp($item);

        if (! $requiresFollowUp) {
            return;
        }

        $content = $item->follow_up_summary
            ?: $item->notes
            ?: 'Aset membutuhkan tindak lanjut dari hasil stock opname.';

        InternalNote::query()->updateOrCreate([
            'stock_opname_item_id' => $item->id,
            'type' => 'follow_up',
        ], [
            'company_id' => $item->company_id,
            'stock_opname_id' => $item->stock_opname_id,
            'created_by' => auth()->id(),
            'priority' => $item->physical_condition === 'rusak_berat' ? 'high' : 'normal',
            'status' => 'open',
            'content' => $content,
        ]);
    }

    public function itemRequiresFollowUp(StockOpnameItem $item): bool
    {
        if ((bool) $item->need_follow_up) {
            return true;
        }

        if (in_array($item->result_status, ['tidak_sesuai', 'perlu_tindak_lanjut', 'tidak_ada'], true)) {
            return true;
        }

        if (in_array($item->physical_condition, ['rusak_ringan', 'rusak_berat'], true)) {
            return true;
        }

        $checklist = collect($item->checklist_data ?? []);
        return $checklist->contains(fn ($row) => ($row['status'] ?? 'baik') !== 'baik');
    }

    public function statusLabel(?string $status): string
    {
        return match ($status) {
            'pending' => 'Belum Dicek',
            'sesuai' => 'Sesuai',
            'tidak_sesuai' => 'Tidak Sesuai',
            'perlu_tindak_lanjut' => 'Perlu Tindak Lanjut',
            'tidak_ada' => 'Tidak Ditemukan',
            'draft' => 'Draft',
            'in_progress' => 'Berjalan',
            'need_follow_up' => 'Perlu Tindak Lanjut',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $status ?: '-',
        };
    }

    public function conditionLabel(?string $condition): string
    {
        return match ($condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            default => $condition ?: '-',
        };
    }
}
