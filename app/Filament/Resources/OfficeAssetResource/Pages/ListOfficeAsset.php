<?php
namespace App\Filament\Resources\OfficeAssetResource\Pages;

use App\Filament\Resources\OfficeAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfficeAsset extends ListRecords
{
    protected static string $resource = OfficeAssetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
