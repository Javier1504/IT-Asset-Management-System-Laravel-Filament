<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
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

class LocationResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = Location::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Lokasi';
    protected static ?string $modelLabel = 'Lokasi';
    protected static ?string $pluralModelLabel = 'Lokasi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('name')->maxLength(255)->required(),
                TextInput::make('code')->maxLength(255),
                TextInput::make('floor')->maxLength(255)->required(),
                Textarea::make('description')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('floor')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocation::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
