<?php

namespace App\Filament\Resources\ProcurementRequests;

use App\Filament\Resources\ProcurementRequests\Pages\CreateProcurementRequest;
use App\Filament\Resources\ProcurementRequests\Pages\EditProcurementRequest;
use App\Filament\Resources\ProcurementRequests\Pages\ListProcurementRequests;
use App\Filament\Resources\ProcurementRequests\Pages\ViewProcurementRequest;
use App\Filament\Resources\ProcurementRequests\Schemas\ProcurementRequestForm;
use App\Filament\Resources\ProcurementRequests\Schemas\ProcurementRequestInfolist;
use App\Filament\Resources\ProcurementRequests\Tables\ProcurementRequestsTable;
use App\Models\ProcurementRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ProcurementRequestResource extends Resource
{
    protected static ?string $model = ProcurementRequest::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $recordTitleAttribute = 'item_name';

    protected static ?string $navigationLabel = 'Pengadaan Barang';

    protected static ?string $modelLabel = 'Request Pengadaan';

    protected static ?string $pluralModelLabel = 'Request Pengadaan';

    protected static string | UnitEnum | null $navigationGroup = 'Layanan IT';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProcurementRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProcurementRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcurementRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return $query;
        }

        if ($user->hasRole('manager')) {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('requester_id', $user->id)
                    ->orWhere('manager_id', $user->id);
            });
        }

        if ($user->hasRole('finance')) {
            return $query->where('finance_id', $user->id);
        }

        if ($user->hasRole('user')) {
            return $query->where('employee_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole([
            'superadmin',
            'admin',
            'manager',
            'finance',
            'user',
        ]) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasRole('manager')
            || auth()->user()?->hasAnyRole(['superadmin', 'admin']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        if ($user->hasRole('manager')) {
            return (int) $record->requester_id === (int) $user->id
                || (int) $record->manager_id === (int) $user->id;
        }

        if ($user->hasRole('finance')) {
            return (int) $record->finance_id === (int) $user->id;
        }

        if ($user->hasRole('user')) {
            return (int) $record->employee_id === (int) $user->id;
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasAnyRole(['superadmin', 'admin']) ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->hasAnyRole(['superadmin', 'admin']) ?? false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProcurementRequests::route('/'),
            'create' => CreateProcurementRequest::route('/create'),
            'view' => ViewProcurementRequest::route('/{record}'),
            'edit' => EditProcurementRequest::route('/{record}/edit'),
        ];
    }
}