<?

namespace App\Modules\UserList\Domain\Aggregate;

use App\Models\User;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use Closure;

class UserListAggregate
{
    private ?UserListEntity $userListEntity = null;
    private null|Closure|User $userEntity = null;
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

    public function getUserEntity()
    {
        if (is_callable($this->userEntity)) {
            $callable = $this->userEntity;
            $this->userEntity = $callable();
        } elseif ($this->userListEntity) {
            $this->userEntity = $this->userListEntity->user()->get();
        }
        return $this->userEntity;
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
