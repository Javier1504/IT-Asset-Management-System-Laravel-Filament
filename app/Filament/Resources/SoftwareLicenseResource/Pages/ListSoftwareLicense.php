<?php
namespace App\Filament\Resources\SoftwareLicenseResource\Pages;

use App\Filament\Resources\SoftwareLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftwareLicense extends ListRecords
{
    protected static string $resource = SoftwareLicenseResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
