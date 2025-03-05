<?php

namespace App\Modules\Shared\Events\UserList;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserListCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $userListItems;

    /**
     * Create a new event instance.
     */
    public function __construct(array $userListItems)
    {
        $this->userListItems = $userListItems;
    }
}
