<?php

namespace App\Modules\Shared\Events\UserList;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserListDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userListId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $userListId)
    {
        $this->userListId = $userListId;
    }
}
