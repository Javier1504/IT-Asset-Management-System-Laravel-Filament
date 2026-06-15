<?php
namespace App\Filament\Resources\SparepartTypeResource\Pages;

use App\Filament\Resources\SparepartTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSparepartType extends EditRecord
{
    protected static string $resource = SparepartTypeResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
