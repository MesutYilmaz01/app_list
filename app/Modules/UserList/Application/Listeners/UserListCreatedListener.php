<?php

namespace App\Modules\UserList\Application\Listeners;

use App\Modules\Shared\Events\UserList\UserListCreatedEvent;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;

class UserListCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private UserListItemManager $userListItemManager,
        private UserListAggregate $userListAggregate
    ) {}

    /**
     * Handle the event.
     */
    public function handle(UserListCreatedEvent $event): void
    {
        try {
            $userListItems = $this->userListItemManager->createMultiple($event->userListItems);
            $this->userListAggregate->setUserLitsItems($userListItems);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
