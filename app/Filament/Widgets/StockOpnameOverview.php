<?php

namespace App\Filament\Widgets;

use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockOpnameOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Sesi Stock Opname', StockOpname::query()->count())
                ->description('Total sesi audit aset')
                ->icon('heroicon-o-clipboard-document-check'),

            Stat::make('Item Belum Dicek', StockOpnameItem::query()
                ->where('result_status', 'pending')
                ->count())
                ->description('Menunggu pengecekan')
                ->icon('heroicon-o-clock'),

            Stat::make('Item Tidak Sesuai', StockOpnameItem::query()
                ->where('result_status', 'mismatch')
                ->count())
                ->description('Butuh tindak lanjut')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
