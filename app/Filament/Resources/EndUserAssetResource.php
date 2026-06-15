<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\EndUserAssetResource\Pages;
use App\Models\EndUserAsset;
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
use Illuminate\Database\Eloquent\Builder;

class EndUserAssetResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = EndUserAsset::class;
    protected static ?string $navigationGroup = 'Inventaris Aset';
    protected static ?string $navigationLabel = 'Aset Pengguna';
    protected static ?string $modelLabel = 'Aset Pengguna';
    protected static ?string $pluralModelLabel = 'Aset Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['asset', 'user']);
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        if ($user->role === 'manager') {
            return $query->whereHas('user', fn (Builder $q) => $q->where('team', $user->team));
        }

        return $query->where('user_id', $user->id);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('asset_id')->relationship('asset','asset_number')->getOptionLabelFromRecordUsing(fn ($record) => $record->asset_number.' - '.$record->name)->required()->searchable()->preload(),
                Select::make('user_id')->relationship('user','name')->required()->searchable()->preload(),
                TextInput::make('classification')->maxLength(255)->required(),
                TextInput::make('previous_status')->maxLength(255)->required()
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('asset.asset_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('asset.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('user.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('classification')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEndUserAsset::route('/'),
            'create' => Pages\CreateEndUserAsset::route('/create'),
            'edit' => Pages\EditEndUserAsset::route('/{record}/edit'),
        ];
    }
}
