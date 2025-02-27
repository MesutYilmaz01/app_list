<?

namespace App\Modules\UserListItem\Domain\Entities;

use App\Models\UserListsItem;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListsItemEntity extends UserListsItem
{
    public function isActive()
    {
        return $this->status == StatusType::ACTIVE->value;
    }
}
