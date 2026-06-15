<?php
namespace App\Filament\Resources\AssetOfferRequestResource\Pages;

use App\Filament\Resources\AssetOfferRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetOfferRequest extends EditRecord
{
    protected static string $resource = AssetOfferRequestResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
