<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\MaintenanceRequest;
use App\Models\ProcurementRequest;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Database\Eloquent\Model;

class AuditableObserver
{
    /**
     * Simpan old values sementara di memory,
     * jangan ditempel ke attribute model karena nanti dianggap kolom database.
     *
     * @var array<int, array<string, mixed>>
     */
    protected static array $oldValuesStore = [];

    public function created(Model $model): void
    {
        if (! $this->shouldAudit($model)) {
            return;
        }

        AuditLogService::log(
            module: AuditLogService::moduleFromModel($model),
            event: 'created',
            model: $model,
            oldValues: null,
            newValues: $model->getAttributes(),
            description: AuditLogService::descriptionFor('created', $model),
        );
    }

    public function updating(Model $model): void
    {
        if (! $this->shouldAudit($model)) {
            return;
        }

        self::$oldValuesStore[spl_object_id($model)] = $model->getOriginal();
    }

    public function updated(Model $model): void
    {
        if (! $this->shouldAudit($model)) {
            return;
        }

        $key = spl_object_id($model);
        $oldValues = self::$oldValuesStore[$key] ?? [];
        $newValues = $model->getChanges();

        unset(self::$oldValuesStore[$key]);

        if (empty($newValues)) {
            return;
        }

        AuditLogService::log(
            module: AuditLogService::moduleFromModel($model),
            event: 'updated',
            model: $model,
            oldValues: $oldValues,
            newValues: $newValues,
            description: AuditLogService::descriptionFor('updated', $model),
        );
    }

    public function deleted(Model $model): void
    {
        if (! $this->shouldAudit($model)) {
            return;
        }

        AuditLogService::log(
            module: AuditLogService::moduleFromModel($model),
            event: 'deleted',
            model: $model,
            oldValues: $model->getOriginal(),
            newValues: null,
            description: AuditLogService::descriptionFor('deleted', $model),
        );
    }

    protected function shouldAudit(Model $model): bool
    {
        return $model instanceof Asset
            || $model instanceof MaintenanceRequest
            || $model instanceof ProcurementRequest
            || $model instanceof User;
    }
}