<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetMaintenanceResource\Pages;
use App\Models\AssetMaintenance;
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

class AssetMaintenanceResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetMaintenance::class;
    protected static ?string $navigationGroup = 'Operasional Aset';
    protected static ?string $navigationLabel = 'Perbaikan Aset';
    protected static ?string $modelLabel = 'Perbaikan Aset';
    protected static ?string $pluralModelLabel = 'Perbaikan Aset';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('form_number')->maxLength(255)->required(),
                DatePicker::make('letter_date'),
                Select::make('technician_id')->relationship('technician','name')->searchable()->preload(),
                Select::make('holder_id')->relationship('holder','name')->searchable()->preload(),
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                TextInput::make('device_type')->maxLength(255)->required(),
                Select::make('repair_status')->options(['on_progress'=>'On Progress','done'=>'Done'])->default('on_progress'),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('finished_at'),
                Toggle::make('missing_data'),
                TextInput::make('backup_data')->maxLength(255)->required(),
                Textarea::make('problem_description')->columnSpanFull(),
                Textarea::make('solution')->columnSpanFull(),
                Textarea::make('notes')->columnSpanFull(),
                TextInput::make('sparepart_requirement')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('form_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('technician.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('repair_status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetMaintenance::route('/'),
            'create' => Pages\CreateAssetMaintenance::route('/create'),
            'edit' => Pages\EditAssetMaintenance::route('/{record}/edit'),
        ];
    }
}
