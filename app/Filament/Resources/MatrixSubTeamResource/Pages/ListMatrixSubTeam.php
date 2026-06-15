<?php
namespace App\Filament\Resources\MatrixSubTeamResource\Pages;

use App\Filament\Resources\MatrixSubTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatrixSubTeam extends ListRecords
{
    protected static string $resource = MatrixSubTeamResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
