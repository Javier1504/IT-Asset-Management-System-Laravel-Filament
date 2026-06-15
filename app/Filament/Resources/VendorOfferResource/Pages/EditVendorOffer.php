<?php
namespace App\Filament\Resources\VendorOfferResource\Pages;

use App\Filament\Resources\VendorOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorOffer extends EditRecord
{
    protected static string $resource = VendorOfferResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
