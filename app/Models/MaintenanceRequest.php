<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'requester_id',
        'employee_id',
        'manager_id',
        'technician_id',
        'asset_id',
        'title',
        'description',
        'priority',
        'status',
        'submitted_at',
        'assigned_at',
        'started_at',
        'completed_at',
        'manager_signed_at',
        'employee_signed_at',
        'manager_note',
        'technician_note',
        'completion_note',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'manager_signed_at' => 'datetime',
            'employee_signed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->ticket_number)) {
                $prefix = 'MNT';
                $date = now()->format('Ymd');
                $random = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
                $model->ticket_number = "{$prefix}-{$date}-{$random}";
            }

            if (empty($model->submitted_at)) {
                $model->submitted_at = now();
            }

            if (empty($model->status)) {
                $model->status = 'submitted_by_manager';
            }

            if (empty($model->priority)) {
                $model->priority = 'medium';
            }
        });
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function isSubmittedByManager(): bool
    {
        return $this->status === 'submitted_by_manager';
    }

    public function isAssignedToTechnician(): bool
    {
        return $this->status === 'assigned_to_technician';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompletedByTechnician(): bool
    {
        return $this->status === 'completed_by_technician';
    }

    public function isSignedByManager(): bool
    {
        return $this->status === 'signed_by_manager';
    }

    public function isReceivedByEmployee(): bool
    {
        return $this->status === 'received_by_employee';
    }
}