<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\MaintenanceRequest;
use App\Models\ProcurementRequest;
use App\Models\User;
use App\Observers\AuditableObserver;
use App\Services\AuditLogService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Asset::observe(AuditableObserver::class);
        MaintenanceRequest::observe(AuditableObserver::class);
        ProcurementRequest::observe(AuditableObserver::class);
        User::observe(AuditableObserver::class);

        Event::listen(Login::class, function (Login $event) {
            AuditLogService::log(
                module: 'auth',
                event: 'login',
                model: $event->user,
                oldValues: null,
                newValues: [
                    'user_id' => $event->user->id,
                    'email' => $event->user->email,
                    'name' => $event->user->name,
                    'roles' => method_exists($event->user, 'getRoleNames')
                        ? $event->user->getRoleNames()->values()->all()
                        : [],
                ],
                description: 'User login',
                userId: $event->user->id,
            );
        });

        Event::listen(Logout::class, function (Logout $event) {
            if (! $event->user) {
                return;
            }

            AuditLogService::log(
                module: 'auth',
                event: 'logout',
                model: $event->user,
                oldValues: null,
                newValues: [
                    'user_id' => $event->user->id,
                    'email' => $event->user->email,
                    'name' => $event->user->name,
                    'roles' => method_exists($event->user, 'getRoleNames')
                        ? $event->user->getRoleNames()->values()->all()
                        : [],
                ],
                description: 'User logout',
                userId: $event->user->id,
            );
        });
    }
}