<?

namespace App\Modules\UserList\Domain\Aggregate;

use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use Closure;

class UserListAggregate
{
    private ?UserListEntity $userListEntity = null;
    private Closure|null $userEntity = null;
    private IBaseResponse $responseType;

    public function setUserListEntity(UserListEntity $userListEntity)
    {
        $this->userListEntity = $userListEntity;
    }

    public function getUserListEntity()
    {
        return $this->userListEntity;
    }

    public function getUserListItems()
    {
        return $this->userListEntity->userListsItems->toArray();
    }

    public function setUserEntity(UserEntity|Closure $userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function getUserEntity()
    {
        $callable = $this->userEntity;
        return $callable();
    }

    public function setResponseType(IBaseResponse $responseType)
    {
        $this->responseType = $responseType;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function getCategory()
    {
        return $this->userListEntity->category->toArray();
    }
}
