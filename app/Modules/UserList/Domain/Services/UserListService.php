<?

namespace App\Modules\UserList\Domain\Services;

use App\Modules\UserList\Domain\IRepository\IUserListRepository;

class UserListService
{
    public IUserListRepository $userListRepo;
    
    public function __construct(IUserListRepository $userListRepo)
    {
        $this->userListRepo = $userListRepo;
    }
}