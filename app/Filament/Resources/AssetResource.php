<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
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

class AssetResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = Asset::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Aset';
    protected static ?string $modelLabel = 'Aset';
    protected static ?string $pluralModelLabel = 'Aset';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                Select::make('asset_type_id')->relationship('assetType','name')->required()->searchable()->preload(),
                TextInput::make('asset_number')->maxLength(255)->required(),
                TextInput::make('name')->maxLength(255)->required(),
                TextInput::make('brand')->maxLength(255)->required(),
                TextInput::make('model')->maxLength(255),
                TextInput::make('serial_number')->maxLength(255),
                Textarea::make('specification')->columnSpanFull(),
                DatePicker::make('purchase_date'),
                TextInput::make('purchase_price')->numeric()->prefix('Rp'),
                Select::make('condition')->options(['good'=>'Good','minor_issue'=>'Minor Issue','broken'=>'Broken','lost'=>'Lost'])->default('good'),
                Select::make('status')->options(['stock'=>'Stock','used'=>'Used','borrowed'=>'Borrowed','repair'=>'Repair','retirement'=>'Retirement','disposed'=>'Disposed'])->default('stock'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('brand')->searchable()->sortable()->toggleable(),
                TextColumn::make('serial_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('condition')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsset::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
