<?

namespace App\Modules\UserListItem\Domain\Entities;

use App\Models\UserListsItem;
use App\Modules\Shared\Interfaces\Entities\IEntity;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListsItemEntity extends UserListsItem implements IEntity
{
    public function isActive()
    {
        return $this->status == StatusType::ACTIVE->value;
    }
}
