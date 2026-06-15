<?php
namespace App\Filament\Resources\SoftwareLicenseResource\Pages;

use App\Filament\Resources\SoftwareLicenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoftwareLicense extends EditRecord
{
    protected static string $resource = SoftwareLicenseResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
