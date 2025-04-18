<?php

namespace App\Modules\Shared\Events\UserList;

use App\Models\UserList;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserListCreatedNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserList $userList;

    /**
     * Create a new event instance.
     */
    public function __construct(UserList $userList)
    {
        $this->userList = $userList;
    }
}
