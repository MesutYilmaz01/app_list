<?

namespace App\Modules\UserListItem\Domain\Aggregate;

use App\Models\UserListsItem;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\User\Domain\Entities\UserEntity;

class UserListItemAggregate
{
    private ?UserListsItem $userListItemEntity = null;
    private ?UserEntity $userEntity = null;
    private IBaseResponse $responseType;

    public function setUserListItemEntity(UserListsItem $userListItemEntity)
    {
        $this->userListItemEntity = $userListItemEntity;
    }

    public function getUserListItemEntity()
    {
        return $this->userListItemEntity;
    }

    public function setUserEntity(UserEntity $userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function getUserEntity()
    {
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
}
