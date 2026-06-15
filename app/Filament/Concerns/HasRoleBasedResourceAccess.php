<?php

namespace App\Filament\Concerns;

use App\Support\RoleAccess;
use Illuminate\Database\Eloquent\Model;

trait HasRoleBasedResourceAccess
{
    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function canViewAny(): bool
    {
        return RoleAccess::canViewResource(static::class, static::$navigationGroup ?? null);
    }

    public static function canCreate(): bool
    {
        return RoleAccess::canCreateResource(static::class, static::$navigationGroup ?? null);
    }

    public static function canEdit(Model $record): bool
    {
        return RoleAccess::canUpdateResource(static::class, static::$navigationGroup ?? null);
    }

    public static function canDelete(Model $record): bool
    {
        return RoleAccess::canDeleteResource(static::class, static::$navigationGroup ?? null);
    }

    public static function canDeleteAny(): bool
    {
        return RoleAccess::canDeleteResource(static::class, static::$navigationGroup ?? null);
    }
}
