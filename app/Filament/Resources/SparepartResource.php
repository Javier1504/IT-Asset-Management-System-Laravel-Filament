<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SparepartResource\Pages;
use App\Models\Sparepart;
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

class SparepartResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = Sparepart::class;
    protected static ?string $navigationGroup = 'Sparepart';
    protected static ?string $navigationLabel = 'Sparepart';
    protected static ?string $modelLabel = 'Sparepart';
    protected static ?string $pluralModelLabel = 'Sparepart';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('sparepart_type_id')->relationship('sparepartType','name')->required()->searchable()->preload(),
                TextInput::make('name')->maxLength(255)->required(),
                TextInput::make('stock')->numeric(),
                TextInput::make('minimum_stock')->numeric()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('sparepartType.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('stock')->searchable()->sortable()->toggleable(),
                TextColumn::make('minimum_stock')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSparepart::route('/'),
            'create' => Pages\CreateSparepart::route('/create'),
            'edit' => Pages\EditSparepart::route('/{record}/edit'),
        ];
    }
}
