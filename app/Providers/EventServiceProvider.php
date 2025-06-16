<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\SendOrderNotificationToWorkers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Tambahkan ini untuk notifikasi order
        OrderCreated::class => [
            SendOrderNotificationToWorkers::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
