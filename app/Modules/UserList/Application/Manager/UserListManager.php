<?

namespace App\Modules\UserList\Application\Manager;

use App\Models\UserList;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Services\UserListService;
use Exception;
use Illuminate\Support\Facades\Log;

class UserListManager
{
    private UserListService $userListService;

    public function __construct(UserListService $userListService)
    {
        $this->userListService = $userListService;
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
        $userList = $this->userListService->create($userListDTO);

        if(!$userList) {
            Log::alert("Userlist could not created.");
            throw new Exception("Userlist could not created.", 400);
        }

        Log::info("Userlist {$userList->id} is created.");
        return $userList;
    }
}
