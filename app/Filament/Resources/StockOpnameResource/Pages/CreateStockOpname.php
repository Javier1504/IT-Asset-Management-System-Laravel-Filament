<?php

namespace App\Filament\Resources\StockOpnameResource\Pages;

use App\Filament\Resources\StockOpnameResource;
use App\Services\StockOpname\StockOpnameService;
use Filament\Resources\Pages\CreateRecord;

class CreateStockOpname extends CreateRecord
{
    protected static string $resource = StockOpnameResource::class;

    protected array $targetData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->targetData = [
            'target_team_ids' => $data['target_team_ids'] ?? [],
            'target_team_id' => $data['target_team_id'] ?? null,
            'target_user_ids' => $data['target_user_ids'] ?? [],
        ];

        unset(
            $data['target_team_ids'],
            $data['target_team_id'],
            $data['target_user_ids']
        );

        return $data;
    }

    protected function afterCreate(): void
    {
        app(StockOpnameService::class)->generateTargets(
            stockOpname: $this->record,
            targetData: $this->targetData
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', [
            'record' => $this->record,
        ]);
    }
}