<?php

namespace App\Support;

use App\Models\User;

class RoleAccess
{
    public static function user(): ?User
    {
        return auth()->user();
    }

    public static function role(): string
    {
        return (string) (self::user()?->role ?? 'guest');
    }

    public static function isAdmin(?User $user = null): bool
    {
        $user ??= self::user();
        return $user && in_array($user->role, ['super_admin', 'admin'], true);
    }

    public static function isManager(?User $user = null): bool
    {
        $user ??= self::user();
        return $user && in_array($user->role, ['super_admin', 'admin', 'manager'], true);
    }

    public static function isEmployee(?User $user = null): bool
    {
        $user ??= self::user();
        return $user && in_array($user->role, ['employee', 'user', 'pegawai'], true);
    }

    public static function canViewResource(string $resourceClass, ?string $group = null): bool
    {
        $user = self::user();
        if (! $user || $user->status !== 'active') {
            return false;
        }

        if (self::isAdmin($user)) {
            return true;
        }

        $resource = class_basename($resourceClass);

        if ($user->role === 'manager') {
            return in_array($resource, [
                'AssetResource',
                'EndUserAssetResource',
                'OfficeAssetResource',
                'AssetRequestResource',
                'AssetMaintenanceResource',
                'AssetInstallationResource',
                'AssetDisposalResource',
                'StockOpnameResource',
                'InternalNoteResource',
                'UserResource',
            ], true);
        }

        return in_array($resource, [
            'EndUserAssetResource',
            'AssetRequestResource',
            'StockOpnameResource',
        ], true);
    }

    public static function canCreateResource(string $resourceClass, ?string $group = null): bool
    {
        $user = self::user();
        if (! $user || $user->status !== 'active') {
            return false;
        }

        if (self::isAdmin($user)) {
            return true;
        }

        $resource = class_basename($resourceClass);

        if ($user->role === 'manager') {
            return in_array($resource, [
                'AssetRequestResource',
                'AssetMaintenanceResource',
                'AssetInstallationResource',
                'AssetDisposalResource',
                'StockOpnameResource',
                'InternalNoteResource',
            ], true);
        }

        return $resource === 'AssetRequestResource';
    }

    public static function canUpdateResource(string $resourceClass, ?string $group = null): bool
    {
        $user = self::user();
        if (! $user || $user->status !== 'active') {
            return false;
        }

        if (self::isAdmin($user)) {
            return true;
        }

        $resource = class_basename($resourceClass);

        if ($user->role === 'manager') {
            return in_array($resource, [
                'AssetRequestResource',
                'AssetMaintenanceResource',
                'AssetInstallationResource',
                'AssetDisposalResource',
                'StockOpnameResource',
                'InternalNoteResource',
            ], true);
        }

        return false;
    }

    public static function canDeleteResource(string $resourceClass, ?string $group = null): bool
    {
        return self::isAdmin();
    }
}
