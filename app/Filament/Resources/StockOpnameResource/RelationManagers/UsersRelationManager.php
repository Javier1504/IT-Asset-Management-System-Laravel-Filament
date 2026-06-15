<?php

namespace App\Filament\Resources\StockOpnameResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $title = 'Personel Target';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('team')->label('Tim')->disabled()->dehydrated(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('opnameTeam.team')->label('Tim'),
                TextColumn::make('user.name')->label('Personel')->searchable(),
                TextColumn::make('user.job_title')->label('Jabatan'),
                TextColumn::make('team')->label('Tim Snapshot'),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
