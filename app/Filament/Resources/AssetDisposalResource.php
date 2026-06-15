<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetDisposalResource\Pages;
use App\Models\AssetDisposal;
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

class AssetDisposalResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetDisposal::class;
    protected static ?string $navigationGroup = 'Operasional Aset';
    protected static ?string $navigationLabel = 'Pemusnahan Aset';
    protected static ?string $modelLabel = 'Pemusnahan Aset';
    protected static ?string $pluralModelLabel = 'Pemusnahan Aset';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('document_number')->maxLength(255)->required(),
                TextInput::make('method')->maxLength(255)->required(),
                DatePicker::make('disposal_date'),
                TextInput::make('location')->maxLength(255)->required(),
                Select::make('status')->options(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected','on_progress'=>'On Progress','done'=>'Done'])->default('pending'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('document_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('method')->searchable()->sortable()->toggleable(),
                TextColumn::make('disposal_date')->dateTime()->sortable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getRelations(): array
    {
        return [\App\Filament\Resources\AssetDisposalResource\RelationManagers\ItemsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetDisposal::route('/'),
            'create' => Pages\CreateAssetDisposal::route('/create'),
            'edit' => Pages\EditAssetDisposal::route('/{record}/edit'),
        ];
    }
}
