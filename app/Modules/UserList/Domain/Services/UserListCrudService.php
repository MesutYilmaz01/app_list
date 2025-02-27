<?

namespace App\Modules\UserList\Domain\Services;

use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;

class UserListCrudService
{

    public function __construct(
        private IUserListRepository $userListRepo,
        private UserListAggregate $userListAggregate
    ) {}

    /**
     * Gets all user lists for given id
     * 
     * @param int $userId
     * @return array||null
     */
    public function getAllForUser(int $userId): ?array
    {
        return $this->userListRepo->getAllByAttributes([
            'user_id' => $userId,
            'status' => StatusType::ACTIVE->value,
            'is_public' => ShareType::PUBLIC->value
        ])->toArray();
    }

    /**
     * Gets a user list for given id
     * 
     * @param int $listId
     * @return UserListEntity||null
     */
    public function get(int $listId): ?UserListEntity
    {
        $userList = $this->userListRepo->findByAttributes([
            'id' => $listId,
            'status' => StatusType::ACTIVE->value,
            'is_public' => ShareType::PUBLIC->value
        ]);

        if (!$userList) {
            return null;
        }
        
        $this->userListAggregate->setUserListEntity($userList);
        return $this->userListAggregate->getUserListEntity();
    }

    /**
     * Creates a userlist according to given data
     * 
     * @param UserListDTO $userListDTO
     * @return UserListEntity||null
     */
    public function create(UserListDTO $userListDTO): ?UserListEntity
    {
        return $this->userListRepo->create($userListDTO->toArray());
    }
}
