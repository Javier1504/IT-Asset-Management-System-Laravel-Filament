<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetInstallationResource\Pages;
use App\Models\AssetInstallation;
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

class AssetInstallationResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetInstallation::class;
    protected static ?string $navigationGroup = 'Operasional Aset';
    protected static ?string $navigationLabel = 'Instalasi Aset';
    protected static ?string $modelLabel = 'Instalasi Aset';
    protected static ?string $pluralModelLabel = 'Instalasi Aset';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                Select::make('installed_for')->relationship('user','name')->searchable()->preload(),
                Select::make('location_id')->relationship('location','name')->searchable()->preload(),
                DatePicker::make('installed_at'),
                Select::make('status')->options(['active'=>'Active','inactive'=>'Inactive','stock'=>'Stock','used'=>'Used','retired'=>'Retired'])->default('active'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('user.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('location.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetInstallation::route('/'),
            'create' => Pages\CreateAssetInstallation::route('/create'),
            'edit' => Pages\EditAssetInstallation::route('/{record}/edit'),
        ];
    }
}
