<?php

namespace App\Filament\Resources\MaintenanceRequests\Pages;

use App\Filament\Resources\MaintenanceRequests\MaintenanceRequestResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRequest extends CreateRecord
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        $defaultTechnicianId = User::query()
            ->where('is_active', true)
            ->whereHas('roles', fn ($q) => $q->where('name', 'technician'))
            ->orderBy('id')
            ->value('id');

        $data['requester_id'] = $user->id;
        $data['submitted_at'] = now();
        $data['priority'] = 'medium';

        if (($user?->hasRole('manager') ?? false) && empty($data['manager_id'])) {
            $data['manager_id'] = $user->id;
        }

        $data['technician_id'] = $defaultTechnicianId;
        $data['assigned_at'] = $defaultTechnicianId ? now() : null;
        $data['status'] = $defaultTechnicianId ? 'assigned_to_technician' : 'submitted_by_manager';

        return $data;
    }
}