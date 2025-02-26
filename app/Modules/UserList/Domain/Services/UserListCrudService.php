<?

namespace App\Modules\UserList\Domain\Services;

use App\Models\UserList;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;

class UserListCrudService
{
    public IUserListRepository $userListRepo;
    
    public function __construct(IUserListRepository $userListRepo)
    {
        $this->userListRepo = $userListRepo;
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