<?php
namespace App\Filament\Resources;

use App\Filament\Resources\StockOpnameChecklistTemplateResource\Pages;
use App\Models\StockOpnameChecklistTemplate;
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

class StockOpnameChecklistTemplateResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = StockOpnameChecklistTemplate::class;
    protected static ?string $navigationGroup = 'Stock Opname';
    protected static ?string $navigationLabel = 'Template Checklist';
    protected static ?string $modelLabel = 'Template Checklist';
    protected static ?string $pluralModelLabel = 'Template Checklist';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_category')->options(['end_user'=>'End User','office'=>'Office','physical_host'=>'Host Fisik / Server','network'=>'Network','security'=>'Perangkat Keamanan'])->required(),
                TextInput::make('label')->maxLength(255)->required(),
                TextInput::make('key')->maxLength(255)->required(),
                Toggle::make('is_required'),
                Toggle::make('is_active')
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset_category')->searchable()->sortable()->toggleable(),
                TextColumn::make('label')->searchable()->sortable()->toggleable(),
                TextColumn::make('key')->searchable()->sortable()->toggleable(),
                TextColumn::make('is_required')->searchable()->sortable()->toggleable(),
                TextColumn::make('is_active')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOpnameChecklistTemplate::route('/'),
            'create' => Pages\CreateStockOpnameChecklistTemplate::route('/create'),
            'edit' => Pages\EditStockOpnameChecklistTemplate::route('/{record}/edit'),
        ];
    }
}
