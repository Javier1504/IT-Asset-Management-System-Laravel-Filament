<?php
namespace App\Filament\Resources\AssetDisposalResource\RelationManagers;
use Filament\Forms\Components\Select; use Filament\Forms\Components\Textarea; use Filament\Forms\Components\TextInput; use Filament\Forms\Form; use Filament\Resources\RelationManagers\RelationManager; use Filament\Tables; use Filament\Tables\Columns\TextColumn; use Filament\Tables\Table;
class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    public function form(Form $form): Form { return $form->schema([Select::make('asset_id')->relationship('asset','asset_number')->searchable()->preload(), Select::make('sparepart_id')->relationship('sparepart','name')->searchable()->preload(), TextInput::make('quantity')->numeric()->default(1), TextInput::make('manual_type'), TextInput::make('manual_brand'), TextInput::make('manual_number'), Textarea::make('notes')->columnSpanFull()])->columns(2); }
    public function table(Table $table): Table { return $table->columns([TextColumn::make('asset.asset_number'), TextColumn::make('sparepart.name'), TextColumn::make('quantity'), TextColumn::make('manual_number')])->headerActions([Tables\Actions\CreateAction::make()])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]); }
}
