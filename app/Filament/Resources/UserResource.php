<?php
namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Support\RoleAccess;
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
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        if ($user->role === 'manager') {
            return $query->where('team', $user->team);
        }

        return $query->whereKey($user->id);
    }

    public static function canCreate(): bool
    {
        return RoleAccess::isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        return RoleAccess::isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
                Select::make('company_id')->relationship('company','name')->searchable()->preload(),
                TextInput::make('name')->label('Nama')->maxLength(255)->required(),
                TextInput::make('employee_number')->label('NIP / Nomor Pegawai')->maxLength(255),
                TextInput::make('email')->label('Email')->email()->maxLength(255)->required(),
                TextInput::make('password')->label('Password')->password()->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)->dehydrated(fn ($state) => filled($state))->maxLength(255),
                Select::make('role')->options(['super_admin'=>'Super Admin','admin'=>'Admin','manager'=>'Manager','finance'=>'Finance','employee'=>'Pegawai'])->required(),
                Select::make('status')->options(['active'=>'Aktif','inactive'=>'Tidak Aktif'])->default('active'),
                TextInput::make('job_title')->label('Jabatan')->maxLength(255)->required(),
                TextInput::make('job_family')->label('Unit / Divisi')->maxLength(255)->required(),
                TextInput::make('team')->label('Tim')->maxLength(255)->required(),
                TextInput::make('phone')->label('No. Telepon')->maxLength(255)
            ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable()->toggleable(),
                TextColumn::make('role')->label('Role')->searchable()->sortable()->toggleable(),
                TextColumn::make('team')->label('Tim')->searchable()->sortable()->toggleable(),
                TextColumn::make('job_title')->label('Jabatan')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->label('Status')->searchable()->sortable()->toggleable()
            ])->filters([])->actions([Tables\Actions\EditAction::make()])->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUser::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
