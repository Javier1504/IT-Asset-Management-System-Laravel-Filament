<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\VendorOfferResource\Pages;
use App\Models\VendorOffer;
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

class VendorOfferResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = VendorOffer::class;
    protected static ?string $navigationGroup = 'Pengadaan';
    protected static ?string $navigationLabel = 'Penawaran Vendor';
    protected static ?string $modelLabel = 'Penawaran Vendor';
    protected static ?string $pluralModelLabel = 'Penawaran Vendor';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_offer_request_id')->relationship('request','item_name')->required()->searchable()->preload(),
                Select::make('vendor_id')->relationship('vendor','name')->searchable()->preload(),
                TextInput::make('vendor_name')->maxLength(255)->required(),
                TextInput::make('offer_number')->maxLength(255)->required(),
                DatePicker::make('offer_date'),
                DatePicker::make('valid_until'),
                TextInput::make('unit_price')->numeric()->prefix('Rp'),
                TextInput::make('total_price')->numeric()->prefix('Rp'),
                TextInput::make('warranty')->maxLength(255)->required(),
                TextInput::make('delivery_estimation')->maxLength(255)->required(),
                Select::make('status')->options(['submitted'=>'Submitted','selected'=>'Selected','rejected'=>'Rejected'])->default('submitted'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('request.item_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('vendor.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('vendor_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('total_price')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendorOffer::route('/'),
            'create' => Pages\CreateVendorOffer::route('/create'),
            'edit' => Pages\EditVendorOffer::route('/{record}/edit'),
        ];
    }
}
