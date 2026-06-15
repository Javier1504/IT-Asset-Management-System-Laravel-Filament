<?php
namespace App\Filament\Resources\SecurityPeripheralResource\Pages;

use App\Filament\Resources\SecurityPeripheralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecurityPeripheral extends ListRecords
{
    protected static string $resource = SecurityPeripheralResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
