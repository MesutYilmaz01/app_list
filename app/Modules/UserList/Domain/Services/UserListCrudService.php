<?

namespace App\Modules\UserList\Domain\Services;

use App\Models\UserList;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use Illuminate\Database\Eloquent\Collection;

class UserListCrudService
{
    public IUserListRepository $userListRepo;

    public function __construct(IUserListRepository $userListRepo)
    {
        $this->userListRepo = $userListRepo;
    }

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
     * @param int $userId
     * @param int $listId
     * @return UserList||null
     */
    public function get(int $userId, int $listId): ?UserList
    {
        return $this->userListRepo->getAllByAttributes(['id' => $listId, 'user_id' => $userId]);
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
