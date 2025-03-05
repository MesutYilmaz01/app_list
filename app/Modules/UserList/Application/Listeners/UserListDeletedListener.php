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
        $isDeleted = $this->userListItemManager->deleteMany($event->userListId);
        
        if(!$isDeleted) {
            throw new Exception("There is a problem while deleting user list sub items", 400);
        }
    }
}
