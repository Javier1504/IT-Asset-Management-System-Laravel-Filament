<?php

namespace App\Filament\Resources\MaintenanceRequests\Pages;

use App\Filament\Resources\MaintenanceRequests\MaintenanceRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceRequests extends ListRecords
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();

        return [
            CreateAction::make()
                ->label('Buat Request Maintenance')
                ->visible(fn (): bool => $user?->hasRole('manager') || $user?->hasAnyRole(['superadmin', 'admin'])),
        ];
    }
}