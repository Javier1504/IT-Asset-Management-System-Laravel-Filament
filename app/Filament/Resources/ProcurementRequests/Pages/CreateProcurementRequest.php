<?php

namespace App\Filament\Resources\ProcurementRequests\Pages;

use App\Filament\Resources\ProcurementRequests\ProcurementRequestResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateProcurementRequest extends CreateRecord
{
    protected static string $resource = ProcurementRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        $defaultFinanceId = User::query()
            ->where('is_active', true)
            ->whereHas('roles', fn ($q) => $q->where('name', 'finance'))
            ->orderBy('id')
            ->value('id');

        $data['requester_id'] = $user->id;
        $data['submitted_at'] = now();
        $data['priority'] = 'medium';

        if (($user?->hasRole('manager') ?? false) && empty($data['manager_id'])) {
            $data['manager_id'] = $user->id;
        }

        $data['finance_id'] = $defaultFinanceId;
        $data['finance_assigned_at'] = $defaultFinanceId ? now() : null;
        $data['status'] = $defaultFinanceId ? 'assigned_to_finance' : 'submitted_by_manager';

        return $data;
    }
}