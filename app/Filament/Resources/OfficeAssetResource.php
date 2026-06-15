<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\OfficeAssetResource\Pages;
use App\Models\OfficeAsset;
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

class OfficeAssetResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = OfficeAsset::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Aset Kantor';
    protected static ?string $modelLabel = 'Aset Kantor';
    protected static ?string $pluralModelLabel = 'Aset Kantor';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                Select::make('location_id')->relationship('location','name')->searchable()->preload(),
                TextInput::make('previous_status')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('asset.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('location.name')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficeAsset::route('/'),
            'create' => Pages\CreateOfficeAsset::route('/create'),
            'edit' => Pages\EditOfficeAsset::route('/{record}/edit'),
        ];
    }
}
