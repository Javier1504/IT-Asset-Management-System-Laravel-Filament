<?php

namespace App\Filament\Resources\StockOpnameItemResource\Pages;

use App\Filament\Resources\StockOpnameItemResource;
use App\Filament\Resources\StockOpnameResource;
use App\Services\StockOpname\StockOpnameService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockOpnameItem extends EditRecord
{
    protected static string $resource = StockOpnameItemResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (empty($data['checklist_data']) && $this->record->asset) {
            $data['checklist_data'] = app(StockOpnameService::class)
                ->defaultChecklistDataForAsset($this->record->asset);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_stock_opname')
                ->label('Kembali ke Stock Opname')
                ->url(fn () => StockOpnameResource::getUrl('view', ['record' => $this->record->stock_opname_id])),
        ];
    }

    protected function afterSave(): void
    {
        app(StockOpnameService::class)->syncInternalNoteFromItem($this->record);
        app(StockOpnameService::class)->markNeedFollowUpIfNeeded($this->record->stockOpname);
    }

    protected function getRedirectUrl(): string
    {
        return StockOpnameResource::getUrl('view', ['record' => $this->record->stock_opname_id]);
    }
}
