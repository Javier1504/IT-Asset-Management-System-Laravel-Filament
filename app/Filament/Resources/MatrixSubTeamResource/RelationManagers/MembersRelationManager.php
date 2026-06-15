<?php
namespace App\Filament\Resources\MatrixSubTeamResource\RelationManagers;
use Filament\Forms\Components\Select; use Filament\Forms\Components\TextInput; use Filament\Forms\Components\Toggle; use Filament\Forms\Form; use Filament\Resources\RelationManagers\RelationManager; use Filament\Tables; use Filament\Tables\Columns\IconColumn; use Filament\Tables\Columns\TextColumn; use Filament\Tables\Table;
class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';
    public function form(Form $form): Form { return $form->schema([Select::make('user_id')->relationship('user','name')->required()->searchable()->preload(), TextInput::make('role_label'), Toggle::make('is_leader')]); }
    public function table(Table $table): Table { return $table->columns([TextColumn::make('user.name')->searchable(), TextColumn::make('role_label'), IconColumn::make('is_leader')->boolean()])->headerActions([Tables\Actions\CreateAction::make()])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]); }
}
