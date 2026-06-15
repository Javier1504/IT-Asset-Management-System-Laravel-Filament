<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\VendorResource\Pages;
use App\Models\Vendor;
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

class VendorResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = Vendor::class;
    protected static ?string $navigationGroup = 'Pengadaan';
    protected static ?string $navigationLabel = 'Vendor';
    protected static ?string $modelLabel = 'Vendor';
    protected static ?string $pluralModelLabel = 'Vendor';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('name')->maxLength(255)->required(),
                TextInput::make('pic_name')->maxLength(255)->required(),
                TextInput::make('email')->email()->maxLength(255)->required(),
                TextInput::make('phone')->maxLength(255),
                Textarea::make('address')->columnSpanFull(),
                TextInput::make('category')->maxLength(255)->required(),
                Select::make('status')->options(['active'=>'Active','inactive'=>'Inactive','stock'=>'Stock','used'=>'Used','retired'=>'Retired'])->default('active'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('pic_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->searchable()->sortable()->toggleable(),
                TextColumn::make('category')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendor::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
