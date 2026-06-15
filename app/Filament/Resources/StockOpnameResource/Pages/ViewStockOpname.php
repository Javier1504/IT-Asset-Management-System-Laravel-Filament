<?php

namespace App\Filament\Resources\StockOpnameResource\Pages;

use App\Filament\Resources\StockOpnameItemResource;
use App\Filament\Resources\StockOpnameResource;
use App\Models\StockOpname;
use App\Services\StockOpname\StockOpnameService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewStockOpname extends ViewRecord
{
    protected static string $resource = StockOpnameResource::class;

    protected static string $view = 'filament.resources.stock-opname-resource.pages.view-stock-opname';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('regenerate')
                ->label('Generate Ulang Item')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status !== 'completed')
                ->action(function () {
                    $count = app(StockOpnameService::class)->generateItems($this->record);
                    app(StockOpnameService::class)->recalculateSummary($this->record);

                    Notification::make()
                        ->title("Item pemeriksaan digenerate: {$count}")
                        ->success()
                        ->send();
                }),

            Actions\Action::make('complete')
                ->label('Selesaikan Stock Opname')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status !== 'completed')
                ->action(function () {
                    $service = app(StockOpnameService::class);

                    if (! $service->canComplete($this->record)) {
                        $service->markNeedFollowUpIfNeeded($this->record);
                        Notification::make()
                            ->title('Belum bisa diselesaikan')
                            ->body('Masih ada aset belum dicek atau aset yang perlu tindak lanjut.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $service->complete($this->record);
                    Notification::make()->title('Stock opname selesai')->success()->send();
                    $this->redirect(StockOpnameResource::getUrl('view', ['record' => $this->record]));
                }),

            Actions\EditAction::make()->label('Edit Info'),
        ];
    }

    protected function getViewData(): array
    {
        /** @var StockOpname $record */
        $record = $this->record->load([
            'teams.users.user',
            'users.user.endUserAssets.asset.assetType',
            'items.asset.assetType',
            'items.user',
            'items.location',
            'internalNotes.creator',
            'checker',
        ]);

        $service = app(StockOpnameService::class);
        $summary = $service->recalculateSummary($record);

        return [
            'stockOpname' => $record,
            'summary' => $summary,
            'itemsByUser' => $record->items->where('asset_source', 'end_user')->groupBy('user_id'),
            'officeItems' => $record->items->where('asset_source', 'office')->values(),
            'itemEditUrl' => fn ($item) => StockOpnameItemResource::getUrl('edit', ['record' => $item]),
            'statusLabel' => fn (?string $status) => $service->statusLabel($status),
            'conditionLabel' => fn (?string $condition) => $service->conditionLabel($condition),
        ];
    }
}
