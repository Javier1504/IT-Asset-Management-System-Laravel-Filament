<?php
namespace App\Observers;

use App\Models\AuditTrail;
use Illuminate\Database\Eloquent\Model;

class AuditTrailObserver
{
    public static array $models = [
        \App\Models\Asset::class, \App\Models\EndUserAsset::class, \App\Models\OfficeAsset::class,
        \App\Models\AssetRequest::class, \App\Models\AssetMaintenance::class, \App\Models\AssetDisposal::class,
        \App\Models\SoftwareLicense::class, \App\Models\StockOpname::class, \App\Models\StockOpnameItem::class,
        \App\Models\Vendor::class, \App\Models\AssetOfferRequest::class, \App\Models\VendorOffer::class,
    ];
    public static function registerObservedModels(): void { foreach (self::$models as $model) { $model::observe(self::class); } }
    public function created(Model $model): void { $this->record('created', $model, null, $model->getAttributes()); }
    public function updated(Model $model): void { $this->record('updated', $model, $model->getOriginal(), $model->getChanges()); }
    public function deleted(Model $model): void { $this->record('deleted', $model, $model->getOriginal(), null); }
    protected function record(string $event, Model $model, ?array $old, ?array $new): void
    {
        if ($model instanceof AuditTrail) return;
        AuditTrail::query()->create([
            'user_id' => auth()->id(), 'event' => $event, 'module' => class_basename($model),
            'auditable_type' => get_class($model), 'auditable_id' => $model->getKey(),
            'old_values' => $old, 'new_values' => $new,
            'ip_address' => request()?->ip(), 'user_agent' => request()?->userAgent(),
            'description' => class_basename($model).' '.$event,
        ]);
    }
}
