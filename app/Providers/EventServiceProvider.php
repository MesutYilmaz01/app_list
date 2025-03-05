<?php

namespace App\Providers;

use App\Modules\Shared\Events\UserList\UserListCreatedEvent;
use App\Modules\UserList\Application\Listeners\UserListCreatedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            UserListCreatedEvent::class,
            [UserListCreatedListener::class, 'handle'],
        );
    }
}
