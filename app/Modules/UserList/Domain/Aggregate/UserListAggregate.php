<?

namespace App\Modules\UserList\Domain\Aggregate;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use Closure;

class UserListAggregate
{
    private ?UserListEntity $userListEntity = null;
    private ?Closure $userEntity = null;
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
        return $this->userListEntity->userListsItems;
    }

    public function setUserEntity(Closure $userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function getUserEntity(int $userId = 0)
    {
        $callable = $this->userEntity;
        return $callable($userId);
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
        return $this->userListEntity->category;
    }

    public function getOwner()
    {
        return $this->userListEntity->user;
    }

    public function getComments()
    {
        return $this->userListEntity->comments;
    }
}
