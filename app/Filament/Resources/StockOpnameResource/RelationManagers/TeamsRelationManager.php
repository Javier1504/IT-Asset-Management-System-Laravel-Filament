<?php

namespace App\Filament\Resources\StockOpnameResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';
    protected static ?string $title = 'Tim Target';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('team')
                ->label('Tim')
                ->disabled()
                ->dehydrated(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('team')
                    ->label('Tim')
                    ->searchable(),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
