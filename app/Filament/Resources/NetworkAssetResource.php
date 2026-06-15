<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\NetworkAssetResource\Pages;
use App\Models\NetworkAsset;
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

class NetworkAssetResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = NetworkAsset::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Aset Jaringan';
    protected static ?string $modelLabel = 'Aset Jaringan';
    protected static ?string $pluralModelLabel = 'Aset Jaringan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                TextInput::make('ip_address')->maxLength(255)->required(),
                TextInput::make('mac_address')->maxLength(255)->required(),
                TextInput::make('network_role')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('ip_address')->searchable()->sortable()->toggleable(),
                TextColumn::make('mac_address')->searchable()->sortable()->toggleable(),
                TextColumn::make('network_role')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNetworkAsset::route('/'),
            'create' => Pages\CreateNetworkAsset::route('/create'),
            'edit' => Pages\EditNetworkAsset::route('/{record}/edit'),
        ];
    }
}
