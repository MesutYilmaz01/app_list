<?

namespace App\Modules\UserList\Domain\Entities;

use App\Models\UserList;
use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListEntity extends UserList
{
    public function isPublic()
    {
        return $this->is_public == ShareType::PUBLIC->value;
    }

    public function isActive()
    {
        return $this->status == StatusType::ACTIVE->value;
    }

    public function makePublic()
    {
        $this->public = ShareType::PUBLIC->value;
    }
}
