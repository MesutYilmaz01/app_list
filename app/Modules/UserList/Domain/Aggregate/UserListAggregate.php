<?

namespace App\Modules\UserList\Domain\Aggregate;

use App\Modules\UserList\Domain\Entities\UserListEntity;

class UserListAggregate
{
    private ?UserListEntity $userListEntity = null;
    private array $userLitsItems;

    public function setUserListEntity(UserListEntity $userListEntity) 
    {
        $this->userListEntity = $userListEntity;
    }

    public function getUserListEntity()
    {
        return $this->userListEntity;
    }

    public function setUserLitsItems(array $userLitsItems) 
    {
        $this->userLitsItems = $userLitsItems;
    }

    public function getUserLitsItems()
    {
        return $this->userLitsItems;
    }
}