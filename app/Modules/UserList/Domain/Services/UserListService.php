<?

namespace App\Modules\UserList\Domain\Services;

use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;

class UserListService
{
    public IUserListRepository $userListRepo;
    
    public function __construct(IUserListRepository $userListRepo)
    {
        $this->userListRepo = $userListRepo;
    }

    public function create(UserListDTO $userListDTO)
    {
        return $this->userListRepo->create($userListDTO->toArray());
    }
}