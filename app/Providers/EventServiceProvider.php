<?php

namespace App\Providers;

use App\Events\UserUpdatedEvent;
use App\Events\UserCreatedEvent;
use App\Events\UserSubscriptionUpdatedEvent;
use App\Listeners\UserCreatedListener;
use App\Listeners\UserUpdatedListener;
use App\Listeners\UserSubscriptionUpdatedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreatedEvent::class => [
            UserCreatedListener::class
        ],
        UserUpdatedEvent::class => [
            UserUpdatedListener::class
        ],
        UserSubscriptionUpdatedEvent::class => [
            UserSubscriptionUpdatedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
