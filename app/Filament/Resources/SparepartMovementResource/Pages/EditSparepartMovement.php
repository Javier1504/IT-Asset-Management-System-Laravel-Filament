<?php
namespace App\Filament\Resources\SparepartMovementResource\Pages;

use App\Filament\Resources\SparepartMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSparepartMovement extends EditRecord
{
    protected static string $resource = SparepartMovementResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
