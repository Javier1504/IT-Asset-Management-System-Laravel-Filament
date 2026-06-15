<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetTypeResource\Pages;
use App\Models\AssetType;
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

class AssetTypeResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetType::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Jenis Aset';
    protected static ?string $modelLabel = 'Jenis Aset';
    protected static ?string $pluralModelLabel = 'Jenis Aset';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                TextInput::make('name')->maxLength(255)->required(),
                Select::make('category')->options(['end_user'=>'End User','office'=>'Office','physical_host'=>'Host Fisik / Server','network'=>'Network','security'=>'Perangkat Keamanan'])->required(),
                TextInput::make('depreciation_method')->maxLength(255)->required(),
                TextInput::make('useful_life_months')->numeric()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('category')->searchable()->sortable()->toggleable(),
                TextColumn::make('useful_life_months')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetType::route('/'),
            'create' => Pages\CreateAssetType::route('/create'),
            'edit' => Pages\EditAssetType::route('/{record}/edit'),
        ];
    }
}
