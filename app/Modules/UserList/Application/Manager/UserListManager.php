<?

namespace App\Modules\UserList\Application\Manager;

use App\Models\UserList;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Services\UserListCrudService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserListManager
{
    private UserListCrudService $userListCrudService;

    public function __construct(UserListCrudService $userListCrudService)
    {
        $this->userListCrudService = $userListCrudService;
    }

    /**
     * Gets all user lists for given id
     * 
     * @param int $userId
     * @return Collection||null
     */
    public function getAllForUser(int $userId): ?Collection
    {
        $userLists = $this->userListCrudService->getAllForUser($userId);

        if (!$userLists) {
            Log::alert("Userlist could not find for {$userId} user.");
            throw new Exception("Userlists could not find.", 400);
        }

        Log::info("Userlist is searched for {$userId} user.");
        return $userLists;
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
        $userList = $this->userListCrudService->get($userId, $listId);

        if (!$userList) {
            Log::alert("Userlist could not find for {$listId} list for {$userId} user.");
            throw new Exception("Userlist could not find.", 400);
        }

        Log::info("Userlist {$listId} is searched for {$userId} user.");
        return $userList;
    }

    /**
     * Creates a userlist according to given data
     * 
     * @param UserListDTO $userListDTO
     * @return UserList||null
     * 
     * @throws Exception
     */
    public function create(UserListDTO $userListDTO): ?UserList
    {
        $userList = $this->userListCrudService->create($userListDTO);

        if (!$userList) {
            Log::alert("Userlist could not created.");
            throw new Exception("Userlist could not created.", 400);
        }

        Log::info("Userlist {$userList->id} is created.");
        return $userList;
    }
}
