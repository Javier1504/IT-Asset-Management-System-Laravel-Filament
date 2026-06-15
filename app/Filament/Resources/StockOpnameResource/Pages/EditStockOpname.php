<?php

namespace App\Filament\Resources\StockOpnameResource\Pages;

use App\Filament\Resources\StockOpnameResource;
use App\Services\StockOpname\StockOpnameService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockOpname extends EditRecord
{
    protected static string $resource = StockOpnameResource::class;

    protected array $targetData = [];

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
    {
        app(StockOpnameService::class)->regenerateTargets(
            stockOpname: $this->record,
            targetData: $this->targetData
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}