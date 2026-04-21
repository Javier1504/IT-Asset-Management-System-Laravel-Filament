<?php

namespace App\Filament\Resources\ProcurementRequests\Pages;

use App\Filament\Resources\ProcurementRequests\ProcurementRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProcurementRequests extends ListRecords
{
    protected static string $resource = ProcurementRequestResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();

        return [
            CreateAction::make()
                ->label('Buat Request Pengadaan')
                ->visible(fn (): bool => $user?->hasRole('manager') || $user?->hasAnyRole(['superadmin', 'admin'])),
        ];
    }
}