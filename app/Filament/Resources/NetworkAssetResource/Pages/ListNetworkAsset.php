<?php
namespace App\Filament\Resources\NetworkAssetResource\Pages;

use App\Filament\Resources\NetworkAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNetworkAsset extends ListRecords
{
    protected static string $resource = NetworkAssetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
