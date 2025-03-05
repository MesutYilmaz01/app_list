<?php

namespace App\Modules\UserList\Application\Listeners;

use App\Modules\Shared\Events\UserList\UserListDeletedEvent;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;

class UserListDeletedListener
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
    public function handle(UserListDeletedEvent $event): void
    {
        try {
            $this->userListItemManager->deleteMany($event->userListId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
