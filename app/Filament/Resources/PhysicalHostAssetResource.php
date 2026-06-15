<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\PhysicalHostAssetResource\Pages;
use App\Models\PhysicalHostAsset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PhysicalHostAssetResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = PhysicalHostAsset::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Host Fisik / Server';
    protected static ?string $modelLabel = 'Host Fisik / Server';
    protected static ?string $pluralModelLabel = 'Host Fisik / Server';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                TextInput::make('hostname')->maxLength(255)->required(),
                TextInput::make('ip_address')->maxLength(255)->required(),
                TextInput::make('os')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('hostname')->searchable()->sortable()->toggleable(),
                TextColumn::make('ip_address')->searchable()->sortable()->toggleable(),
                TextColumn::make('os')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhysicalHostAsset::route('/'),
            'create' => Pages\CreatePhysicalHostAsset::route('/create'),
            'edit' => Pages\EditPhysicalHostAsset::route('/{record}/edit'),
        ];
    }
}
