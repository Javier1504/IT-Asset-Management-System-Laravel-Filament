<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'ticket_code',
        'requested_by',
        'target_user_id',
        'request_type',
        'title',
        'requested_at',
        'asset_type_id',
        'asset_id',
        'desired_asset',
        'reason',
        'attachments',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'attachments' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (AssetRequest $request): void {
            $request->ticket_code = $request->ticket_code ?: self::generateTicketCode();
            $request->requested_at = $request->requested_at ?: now();
            $request->requested_by = $request->requested_by ?: auth()->id();
            $request->target_user_id = $request->target_user_id ?: $request->requested_by;
        });

        static::updating(function (AssetRequest $request): void {
            if ($request->isDirty('ticket_code')) {
                $request->ticket_code = $request->getOriginal('ticket_code');
            }
        });
    }

    public static function generateTicketCode(): string
    {
        $prefix = 'TKT-' . now()->format('Ymd') . '-';
        $last = self::query()
            ->where('ticket_code', 'like', $prefix . '%')
            ->orderByDesc('ticket_code')
            ->value('ticket_code');

        $sequence = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }
}
