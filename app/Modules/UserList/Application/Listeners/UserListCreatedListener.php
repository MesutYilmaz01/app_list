<?php

namespace App\Modules\UserList\Application\Listeners;

use App\Modules\Shared\Events\UserList\UserListCreatedEvent;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;

class UserListCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private UserListItemManager $userListItemManager
    ) {}

    /**
     * Handle the event.
     */
    public function handle(UserListCreatedEvent $event): void
    {
        try {
            $this->userListItemManager->createMultiple($event->userListItems);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
