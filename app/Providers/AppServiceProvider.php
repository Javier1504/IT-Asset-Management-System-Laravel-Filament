<?php

namespace App\Providers;

use App\Models\AuditTrail;
use App\Observers\AuditTrailObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());

        AuditTrailObserver::registerObservedModels();

        Event::listen(Login::class, function (Login $event): void {
            AuditTrail::query()->create([
                'user_id' => $event->user?->id,
                'event' => 'login',
                'module' => 'Authentication',
                'auditable_type' => get_class($event->user),
                'auditable_id' => $event->user?->id,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'description' => ($event->user?->name ?? 'User') . ' login ke sistem',
            ]);
        });

        Event::listen(Logout::class, function (Logout $event): void {
            AuditTrail::query()->create([
                'user_id' => $event->user?->id,
                'event' => 'logout',
                'module' => 'Authentication',
                'auditable_type' => $event->user ? get_class($event->user) : null,
                'auditable_id' => $event->user?->id,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'description' => ($event->user?->name ?? 'User') . ' logout dari sistem',
            ]);
        });
    }
}
