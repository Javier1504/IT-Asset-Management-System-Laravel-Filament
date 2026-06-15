<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\SecurityPeripheralResource\Pages;
use App\Models\SecurityPeripheral;
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

class SecurityPeripheralResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = SecurityPeripheral::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Perangkat Keamanan';
    protected static ?string $modelLabel = 'Perangkat Keamanan';
    protected static ?string $pluralModelLabel = 'Perangkat Keamanan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                TextInput::make('peripheral_type')->maxLength(255)->required(),
                TextInput::make('placement')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('peripheral_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('placement')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSecurityPeripheral::route('/'),
            'create' => Pages\CreateSecurityPeripheral::route('/create'),
            'edit' => Pages\EditSecurityPeripheral::route('/{record}/edit'),
        ];
    }
}
