<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'requester_id',
        'employee_id',
        'manager_id',
        'finance_id',
        'item_name',
        'category',
        'quantity',
        'unit',
        'estimated_price',
        'approved_price',
        'purpose',
        'specification',
        'priority',
        'status',
        'submitted_at',
        'finance_assigned_at',
        'finance_reviewed_at',
        'completed_at',
        'manager_signed_at',
        'employee_signed_at',
        'manager_note',
        'finance_note',
        'completion_note',
    ];

    protected function casts(): array
    {
        return [
            'estimated_price' => 'decimal:2',
            'approved_price' => 'decimal:2',
            'submitted_at' => 'datetime',
            'finance_assigned_at' => 'datetime',
            'finance_reviewed_at' => 'datetime',
            'completed_at' => 'datetime',
            'manager_signed_at' => 'datetime',
            'employee_signed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->request_number)) {
                $prefix = 'PRC';
                $date = now()->format('Ymd');
                $random = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
                $model->request_number = "{$prefix}-{$date}-{$random}";
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

    public function finance()
    {
        return $this->belongsTo(User::class, 'finance_id');
    }

    public function isSubmittedByManager(): bool
    {
        return $this->status === 'submitted_by_manager';
    }

    public function isAssignedToFinance(): bool
    {
        return $this->status === 'assigned_to_finance';
    }

    public function isInReview(): bool
    {
        return $this->status === 'in_review';
    }

    public function isApprovedByFinance(): bool
    {
        return $this->status === 'approved_by_finance';
    }

    public function isRejectedByFinance(): bool
    {
        return $this->status === 'rejected_by_finance';
    }

    public function isCompletedByFinance(): bool
    {
        return $this->status === 'completed_by_finance';
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