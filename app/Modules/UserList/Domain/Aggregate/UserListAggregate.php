<?

namespace App\Modules\UserList\Domain\Aggregate;

use App\Modules\UserList\Domain\Entities\UserListEntity;

class UserListAggregate
{
    private ?UserListEntity $userListEntity = null;
    private array $userListItems;

    public function setUserListEntity(UserListEntity $userListEntity)
    {
        $this->userListEntity = $userListEntity;
    }

    public function getUserListEntity()
    {
        return $this->userListEntity;
    }

    public function setUserListItems(array $userListItems)
    {
        $this->userListItems = $userListItems;
    }

    public function getUserListItems()
    {
        return $this->userListItems;
    }
}
