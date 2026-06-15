<?php
namespace App\Filament\Resources\AssetOfferRequestResource\RelationManagers;
use Filament\Forms\Components\DatePicker; use Filament\Forms\Components\Select; use Filament\Forms\Components\Textarea; use Filament\Forms\Components\TextInput; use Filament\Forms\Form; use Filament\Resources\RelationManagers\RelationManager; use Filament\Tables; use Filament\Tables\Columns\TextColumn; use Filament\Tables\Table;
class OffersRelationManager extends RelationManager
{
    protected static string $relationship = 'offers';
    public function form(Form $form): Form { return $form->schema([Select::make('vendor_id')->relationship('vendor','name')->searchable()->preload(), TextInput::make('vendor_name'), TextInput::make('offer_number'), DatePicker::make('offer_date'), DatePicker::make('valid_until'), TextInput::make('unit_price')->numeric()->prefix('Rp'), TextInput::make('total_price')->numeric()->prefix('Rp'), TextInput::make('warranty'), TextInput::make('delivery_estimation'), Select::make('status')->options(['submitted'=>'Submitted','selected'=>'Selected','rejected'=>'Rejected'])->default('submitted'), Textarea::make('notes')->columnSpanFull()])->columns(2); }
    public function table(Table $table): Table { return $table->columns([TextColumn::make('vendor.name'), TextColumn::make('vendor_name'), TextColumn::make('offer_number'), TextColumn::make('total_price')->money('IDR'), TextColumn::make('status')->badge()])->headerActions([Tables\Actions\CreateAction::make()])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]); }
}
