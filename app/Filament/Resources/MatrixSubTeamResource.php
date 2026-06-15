<?php

namespace App\Filament\Resources;

use App\Models\MatrixSubTeam;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class MatrixSubTeamResource extends Resource
{
    protected static ?string $model = MatrixSubTeam::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [];
    }
}
