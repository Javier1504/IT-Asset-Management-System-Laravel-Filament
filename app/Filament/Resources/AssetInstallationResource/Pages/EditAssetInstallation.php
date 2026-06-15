<?php
namespace App\Filament\Resources\AssetInstallationResource\Pages;

use App\Filament\Resources\AssetInstallationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetInstallation extends EditRecord
{
    protected static string $resource = AssetInstallationResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
