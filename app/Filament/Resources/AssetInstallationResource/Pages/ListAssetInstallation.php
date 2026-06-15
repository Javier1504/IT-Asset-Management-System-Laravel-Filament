<?php
namespace App\Filament\Resources\AssetInstallationResource\Pages;

use App\Filament\Resources\AssetInstallationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetInstallation extends ListRecords
{
    protected static string $resource = AssetInstallationResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
