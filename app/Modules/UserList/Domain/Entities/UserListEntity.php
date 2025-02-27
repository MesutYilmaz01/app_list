<?

namespace App\Modules\UserList\Domain\Entities;

use App\Models\UserList;
use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListEntity extends UserList
{
    public function __construct(private UserList $userList)
    {
        
    }
    
    public function isPublic()
    {
        return $this->userList->is_public == ShareType::PUBLIC->value;
    }

    public function isActive()
    {
        return $this->userList->status == StatusType::ACTIVE->value;
    }

    public function makePublic()
    {
        $this->userList->public = ShareType::PUBLIC->value;
    }

    public function toArray()
    {
        return $this->userList->toArray();
    }
}
