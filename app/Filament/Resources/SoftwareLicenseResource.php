<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\SoftwareLicenseResource\Pages;
use App\Models\SoftwareLicense;
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

class SoftwareLicenseResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = SoftwareLicense::class;
    protected static ?string $navigationGroup = 'Lisensi Software';
    protected static ?string $navigationLabel = 'Lisensi Software';
    protected static ?string $modelLabel = 'Lisensi Software';
    protected static ?string $pluralModelLabel = 'Lisensi Software';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('software_name')->maxLength(255)->required(),
                TextInput::make('category')->maxLength(255)->required(),
                TextInput::make('vendor_name')->maxLength(255)->required(),
                TextInput::make('license_type')->maxLength(255)->required(),
                TextInput::make('license_key')->maxLength(255)->required(),
                TextInput::make('total_license')->numeric(),
                TextInput::make('used_license')->numeric(),
                DatePicker::make('purchase_date'),
                DatePicker::make('start_date'),
                DatePicker::make('expired_date'),
                DatePicker::make('renewal_reminder_date'),
                Select::make('pic_user_id')->relationship('pic','name')->searchable()->preload(),
                Select::make('status')->options(['active'=>'Active','inactive'=>'Inactive','stock'=>'Stock','used'=>'Used','retired'=>'Retired'])->default('active'),
                Textarea::make('notes')->columnSpanFull()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('software_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('vendor_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('total_license')->searchable()->sortable()->toggleable(),
                TextColumn::make('used_license')->searchable()->sortable()->toggleable(),
                TextColumn::make('expired_date')->dateTime()->sortable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoftwareLicense::route('/'),
            'create' => Pages\CreateSoftwareLicense::route('/create'),
            'edit' => Pages\EditSoftwareLicense::route('/{record}/edit'),
        ];
    }
}
