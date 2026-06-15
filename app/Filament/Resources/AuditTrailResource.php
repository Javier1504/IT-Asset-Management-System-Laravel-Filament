<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditTrailResource\Pages;
use App\Models\AuditTrail;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditTrailResource extends Resource
{
    protected static ?string $model = AuditTrail::class;
    protected static ?string $navigationGroup = 'Tata Kelola';
    protected static ?string $navigationLabel = 'Audit Trail';
    protected static ?string $modelLabel = 'Audit Trail';
    protected static ?string $pluralModelLabel = 'Audit Trail';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('event')->label('Event')->badge()->searchable()->sortable(),
                TextColumn::make('module')->label('Module')->searchable()->sortable(),
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('description')->label('Description')->searchable()->wrap(),
                TextColumn::make('ip_address')->label('IP')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Waktu')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditTrail::route('/'),
        ];
    }
}
