<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'code',
        'title',
        'type',
        'scope_type',
        'status',
        'start_date',
        'end_date',
        'checked_by',
        'summary',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'completed_at' => 'datetime',
        'summary' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->code)) {
                $model->code = 'SO-' . now()->format('Ymd-His');
            }

            if (empty($model->status)) {
                $model->status = 'draft';
            }

            if (empty($model->scope_type)) {
                $model->scope_type = 'single_team';
            }
        });

        static::updating(function (self $model): void {
            if ($model->isDirty('code')) {
                $model->code = $model->getOriginal('code');
            }
        });
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function teams()
    {
        return $this->hasMany(StockOpnameTeam::class);
    }

    public function users()
    {
        return $this->hasMany(StockOpnameUser::class);
    }

    public function items()
    {
        return $this->hasMany(StockOpnameItem::class);
    }

    public function internalNotes()
    {
        return $this->hasMany(InternalNote::class);
    }
}
