<?php
namespace App\Filament\Resources\EndUserAssetResource\Pages;

use App\Filament\Resources\EndUserAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEndUserAsset extends ListRecords
{
    protected static string $resource = EndUserAssetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
