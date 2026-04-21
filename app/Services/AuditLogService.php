<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function log(
        string $module,
        string $event,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?int $userId = null
    ): void {
        try {
            $request = request();

            AuditLog::create([
                'user_id' => $userId ?? Auth::id(),
                'module' => $module,
                'event' => $event,
                'auditable_type' => $model ? $model::class : null,
                'auditable_id' => $model?->getKey(),
                'old_values' => self::cleanValues($oldValues),
                'new_values' => self::cleanValues($newValues),
                'description' => $description,
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // sengaja diam agar audit log tidak memutus proses utama aplikasi
        }
    }

    public static function cleanValues(?array $values): ?array
    {
        if (empty($values)) {
            return null;
        }

        unset(
            $values['password'],
            $values['remember_token'],
            $values['created_at'],
            $values['updated_at']
        );

        return $values;
    }

    public static function moduleFromModel(Model $model): string
    {
        return match ($model::class) {
            \App\Models\Asset::class => 'asset',
            \App\Models\MaintenanceRequest::class => 'maintenance',
            \App\Models\ProcurementRequest::class => 'procurement',
            \App\Models\User::class => 'user_management',
            default => 'general',
        };
    }

    public static function descriptionFor(string $event, Model $model): string
    {
        $label = match ($model::class) {
            \App\Models\Asset::class => 'asset',
            \App\Models\MaintenanceRequest::class => 'maintenance request',
            \App\Models\ProcurementRequest::class => 'procurement request',
            \App\Models\User::class => 'user',
            default => class_basename($model),
        };

        return match ($event) {
            'created' => "Created {$label}",
            'updated' => "Updated {$label}",
            'deleted' => "Deleted {$label}",
            default => ucfirst($event) . " {$label}",
        };
    }
}