<?php
namespace App\Filament\Resources\VendorOfferResource\Pages;

use App\Filament\Resources\VendorOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorOffer extends ListRecords
{
    protected static string $resource = VendorOfferResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
