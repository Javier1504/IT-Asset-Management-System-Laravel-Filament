<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SparepartMovementResource\Pages;
use App\Models\SparepartMovement;
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

class SparepartMovementResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = SparepartMovement::class;
    protected static ?string $navigationGroup = 'Sparepart';
    protected static ?string $navigationLabel = 'Mutasi Sparepart';
    protected static ?string $modelLabel = 'Mutasi Sparepart';
    protected static ?string $pluralModelLabel = 'Mutasi Sparepart';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('sparepart_id')->relationship('sparepart','name')->required()->searchable()->preload(),
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->searchable()->preload(),
                Select::make('user_id')->relationship('user','name')->searchable()->preload(),
                Select::make('type')->options(['checkin'=>'Check In','checkout'=>'Check Out'])->required(),
                TextInput::make('quantity')->numeric(),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('sparepart.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('type')->searchable()->sortable()->toggleable(),
                TextColumn::make('quantity')->searchable()->sortable()->toggleable(),
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('user.name')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSparepartMovement::route('/'),
            'create' => Pages\CreateSparepartMovement::route('/create'),
            'edit' => Pages\EditSparepartMovement::route('/{record}/edit'),
        ];
    }
}
