<?

namespace App\Modules\UserList\Domain\Services;

use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;

class UserListCrudService
{

    public function __construct(
        private IUserListRepository $userListRepo
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
     * Gets all lists according to given filter attributes.
     * 
     * @param array $filterParams
     * @return array||null
     */
    public function get(array $filterParams): ?array
    {
        return $this->userListRepo
            ->parseRequest($filterParams)
            ->withFilters($filterParams)
            ->getAll()
            ->toArray();
    }

    /**
     * Gets a user list for given id
     * 
     * @param int $listId
     * @return UserListEntity||null
     */
    public function show(int $listId): ?UserListEntity
    {
        $userList = $this->userListRepo->findByAttributes([
            'id' => $listId,
            'status' => StatusType::ACTIVE->value,
            'is_public' => ShareType::PUBLIC->value
        ]);
        
        if (!$userList) {
            return null;
        }
        
        return $userList;
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

    /**
     * Updates a userlist according to given data
     * 
     * @param int $listId
     * @param userListDTO $userListDTO
     * @return UserListEntity||null
     */
    public function update(int $listId, UserListDTO $userListDTO): ?UserListEntity
    {
        $userList = $this->userListRepo->findByAttributes([
            'id' => $listId,
            'status' => StatusType::ACTIVE->value,
            'is_public' => ShareType::PUBLIC->value
        ]);

        if (!$userList) {
            return null;
        }

        return $this->userListRepo->update($userList, $userListDTO->toArray());
    }

    /**
     * Deletes a user list according to given id
     * 
     * @param int $listId
     * @return bool
     */
    public function delete(int $listId): bool
    {
        $userList = $this->userListRepo->getById($listId);

        if (!$userList) {
            return false;
        }
        return $this->userListRepo->delete($userList);
    }
}
