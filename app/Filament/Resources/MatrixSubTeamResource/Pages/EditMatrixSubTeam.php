<?php
namespace App\Filament\Resources\MatrixSubTeamResource\Pages;

use App\Filament\Resources\MatrixSubTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatrixSubTeam extends EditRecord
{
    protected static string $resource = MatrixSubTeamResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
