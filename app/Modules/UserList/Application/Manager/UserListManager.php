<?

namespace App\Modules\UserList\Application\Manager;

use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Services\UserListService;

class UserListManager
{
    private UserListService $userListService;

    public function __construct(UserListService $userListService)
    {
        $this->userListService = $userListService;
    }

    public function create(UserListDTO $userListDTO)
    {
        return $this->userListService->create($userListDTO);
    }
}
