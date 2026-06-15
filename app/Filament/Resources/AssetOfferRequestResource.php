<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\AssetOfferRequestResource\Pages;
use App\Models\AssetOfferRequest;
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

class AssetOfferRequestResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetOfferRequest::class;
    protected static ?string $navigationGroup = 'Pengadaan';
    protected static ?string $navigationLabel = 'Permintaan Penawaran';
    protected static ?string $modelLabel = 'Permintaan Penawaran';
    protected static ?string $pluralModelLabel = 'Permintaan Penawaran';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('request_number')->maxLength(255)->required(),
                TextInput::make('item_name')->maxLength(255)->required(),
                TextInput::make('item_category')->maxLength(255)->required(),
                Textarea::make('required_specification')->columnSpanFull(),
                TextInput::make('quantity')->numeric(),
                TextInput::make('estimated_unit_budget')->numeric()->prefix('Rp'),
                TextInput::make('estimated_total_budget')->numeric()->prefix('Rp'),
                DatePicker::make('needed_date'),
                Select::make('pic_user_id')->relationship('pic','name')->searchable()->preload(),
                Select::make('status')->options(['open'=>'Open','collecting_offer'=>'Collecting Offer','selected'=>'Selected','closed'=>'Closed'])->default('open'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('request_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('item_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('quantity')->searchable()->sortable()->toggleable(),
                TextColumn::make('estimated_total_budget')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getRelations(): array
    {
        return [\App\Filament\Resources\AssetOfferRequestResource\RelationManagers\OffersRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetOfferRequest::route('/'),
            'create' => Pages\CreateAssetOfferRequest::route('/create'),
            'edit' => Pages\EditAssetOfferRequest::route('/{record}/edit'),
        ];
    }
}
