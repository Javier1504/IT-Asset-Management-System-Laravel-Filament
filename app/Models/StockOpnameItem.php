<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use App\Services\StockOpname\StockOpnameService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'stock_opname_id',
        'end_user_asset_id',
        'office_asset_id',
        'asset_id',
        'user_id',
        'location_id',
        'asset_source',
        'snapshot_asset_number',
        'snapshot_asset_name',
        'snapshot_asset_brand',
        'snapshot_serial_number',
        'snapshot_user_name',
        'snapshot_user_role',
        'snapshot_location_name',
        'result_status',
        'physical_condition',
        'user_match',
        'need_follow_up',
        'issue_type',
        'scheduled_at',
        'additional_budget',
        'follow_up_summary',
        'checklist_data',
        'notes',
        'checked_at',
        'checked_by',
    ];

    protected $casts = [
        'user_match' => 'boolean',
        'need_follow_up' => 'boolean',
        'scheduled_at' => 'datetime',
        'checked_at' => 'datetime',
        'checklist_data' => 'array',
        'additional_budget' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $item): void {
            $service = app(StockOpnameService::class);

            if (empty($item->checklist_data) && $item->asset) {
                $item->checklist_data = $service->defaultChecklistDataForAsset($item->asset);
            }

            if ($item->result_status !== 'pending' && empty($item->checked_at)) {
                $item->checked_at = now();
            }

            if ($item->result_status !== 'pending' && empty($item->checked_by)) {
                $item->checked_by = auth()->id();
            }

            if ($service->itemRequiresFollowUp($item)) {
                $item->need_follow_up = true;

                if ($item->result_status === 'pending') {
                    $item->result_status = 'perlu_tindak_lanjut';
                }
            }
        });

        static::saved(function (self $item): void {
            $service = app(StockOpnameService::class);
            $service->syncInternalNoteFromItem($item);

            if ($item->stockOpname) {
                $service->markNeedFollowUpIfNeeded($item->stockOpname);
            }
        });
    }

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function endUserAsset()
    {
        return $this->belongsTo(EndUserAsset::class);
    }

    public function officeAsset()
    {
        return $this->belongsTo(OfficeAsset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function internalNotes()
    {
        return $this->hasMany(InternalNote::class, 'stock_opname_item_id');
    }
}
