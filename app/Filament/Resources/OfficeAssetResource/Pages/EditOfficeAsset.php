<?php
namespace App\Filament\Resources\OfficeAssetResource\Pages;

use App\Filament\Resources\OfficeAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfficeAsset extends EditRecord
{
    protected static string $resource = OfficeAssetResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
