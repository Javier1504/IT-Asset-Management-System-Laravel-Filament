<?php
namespace App\Filament\Resources\SparepartMovementResource\Pages;

use App\Filament\Resources\SparepartMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSparepartMovement extends ListRecords
{
    protected static string $resource = SparepartMovementResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
