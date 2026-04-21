<?php

namespace App\Filament\Resources\MaintenanceRequests;

use App\Filament\Resources\MaintenanceRequests\Pages\CreateMaintenanceRequest;
use App\Filament\Resources\MaintenanceRequests\Pages\EditMaintenanceRequest;
use App\Filament\Resources\MaintenanceRequests\Pages\ListMaintenanceRequests;
use App\Filament\Resources\MaintenanceRequests\Pages\ViewMaintenanceRequest;
use App\Filament\Resources\MaintenanceRequests\Schemas\MaintenanceRequestForm;
use App\Filament\Resources\MaintenanceRequests\Schemas\MaintenanceRequestInfolist;
use App\Filament\Resources\MaintenanceRequests\Tables\MaintenanceRequestsTable;
use App\Models\MaintenanceRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class MaintenanceRequestResource extends Resource
{
    protected static ?string $model = MaintenanceRequest::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static ?string $modelLabel = 'Request Maintenance';

    protected static ?string $pluralModelLabel = 'Request Maintenance';

    protected static string | UnitEnum | null $navigationGroup = 'Layanan IT';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MaintenanceRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaintenanceRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceRequestsTable::configure($table);
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

        if ($user->hasRole('technician')) {
            return $query->where('technician_id', $user->id);
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
            'technician',
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

        if ($user->hasRole('technician')) {
            return (int) $record->technician_id === (int) $user->id;
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
            'index' => ListMaintenanceRequests::route('/'),
            'create' => CreateMaintenanceRequest::route('/create'),
            'view' => ViewMaintenanceRequest::route('/{record}'),
            'edit' => EditMaintenanceRequest::route('/{record}/edit'),
        ];
    }
}