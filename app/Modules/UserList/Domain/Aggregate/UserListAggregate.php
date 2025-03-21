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
    private array $userListItems;
    private ?UserEntity $userEntity = null;
    private IBaseResponse $responseType;
    private CategoryEntity|Closure|null $category = null;

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

    public function setCategory(CategoryEntity|Closure $category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        if (is_callable($this->category)) {
            $callable = $this->category;
            $this->category = $callable($this->getUserListEntity()->category_id);
        }

        return $this->category;
    }
}
