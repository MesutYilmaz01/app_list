<?

namespace App\Modules\UserList\Domain\Services;

use App\Models\UserList;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use Illuminate\Database\Eloquent\Collection;

class UserListCrudService
{

    public function __construct(private IUserListRepository $userListRepo, private UserListAggregate $userListAggregate) {}

    /**
     * Gets all user lists for given id
     * 
     * @param int $userId
     * @return Collection||null
     */
    public function getAllForUser(int $userId): ?Collection
    {
        return $this->userListRepo->getAllByAttributes(['user_id' => $userId]);
    }

    /**
     * Gets a user list for given id
     * 
     * @param int $listId
     * @return UserListEntity||null
     */
    public function get(int $listId): ?UserListEntity
    {
        $userList = $this->userListRepo->findByAttributes(['id' => $listId]);
        $userListEntity = new UserListEntity($userList);
        $this->userListAggregate->setUserListEntity($userListEntity);
        return $this->userListAggregate->getUserListEntity();
    }

    /**
     * Creates a userlist according to given data
     * 
     * @param UserListDTO $userListDTO
     * @return UserList||null
     */
    public function create(UserListDTO $userListDTO): ?UserList
    {
        return $this->userListRepo->create($userListDTO->toArray());
    }
}
