<?

namespace App\Modules\UserListItem\Domain\Services;

use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;

class UserListService
{
    public IUserListItemRepository $userListItemRepo;
    
    public function __construct(IUserListItemRepository $userListItemRepo)
    {
        $this->userListItemRepo = $userListItemRepo;
    }
}