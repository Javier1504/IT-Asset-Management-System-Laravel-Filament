<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SparepartTypeResource\Pages;
use App\Models\SparepartType;
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

class SparepartTypeResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = SparepartType::class;
    protected static ?string $navigationGroup = 'Sparepart';
    protected static ?string $navigationLabel = 'Jenis Sparepart';
    protected static ?string $modelLabel = 'Jenis Sparepart';
    protected static ?string $pluralModelLabel = 'Jenis Sparepart';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                TextInput::make('name')->maxLength(255)->required(),
                Select::make('category')->options(['sparepart'=>'Sparepart','accessory'=>'Accessory'])->default('sparepart')
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('category')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSparepartType::route('/'),
            'create' => Pages\CreateSparepartType::route('/create'),
            'edit' => Pages\EditSparepartType::route('/{record}/edit'),
        ];
    }
}
