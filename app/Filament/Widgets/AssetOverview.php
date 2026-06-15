<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetRequest;
use App\Models\SoftwareLicense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Aset', Asset::query()->count())
                ->description('Seluruh aset terdaftar')
                ->icon('heroicon-o-computer-desktop')
                ->color('primary'),

            Stat::make('Pengajuan Aktif', AssetRequest::query()->whereNotIn('status', ['done', 'rejected', 'cancelled'])->count())
                ->description('Perlu diproses')
                ->icon('heroicon-o-ticket')
                ->color('warning'),

            Stat::make('Perbaikan Berjalan', AssetMaintenance::query()->whereIn('repair_status', ['on_progress', 'in_progress', 'progress'])->count())
                ->description('Sedang ditangani')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('info'),

            Stat::make('Lisensi Akan Habis', SoftwareLicense::query()->whereNotNull('expired_date')->whereDate('expired_date', '<=', now()->addDays(30))->count())
                ->description('Dalam 30 hari')
                ->icon('heroicon-o-key')
                ->color('danger'),
        ];
    }
}
