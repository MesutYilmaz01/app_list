<?php

namespace App\Providers;

use App\Modules\Notification\Application\Listeners\UserListCreatedNotificationListener;
use App\Modules\Shared\Events\UserList\UserListCreatedEvent;
use App\Modules\Shared\Events\UserList\UserListCreatedNotificationEvent;
use App\Modules\Shared\Events\UserList\UserListDeletedEvent;
use App\Modules\Shared\Observers\UserListObserver;
use App\Modules\UserList\Application\Listeners\UserListCreatedListener;
use App\Modules\UserList\Application\Listeners\UserListDeletedListener;
use App\Modules\UserList\Domain\Entities\UserListEntity;
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
        UserListEntity::observe(UserListObserver::class);

        Event::listen(
            UserListCreatedEvent::class,
            [UserListCreatedListener::class, 'handle'],
        );

        Event::listen(
            UserListDeletedEvent::class,
            [UserListDeletedListener::class, 'handle'],
        );

        Event::listen(
            UserListCreatedNotificationEvent::class,
            [UserListCreatedNotificationListener::class, 'handle'],
        );
    }
}
