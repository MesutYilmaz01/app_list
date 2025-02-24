<?

namespace App\Modules\UserListItem\Domain\Services;

use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;

class UserListItemService
{
    public IUserListItemRepository $userListItemRepo;
    
    public function __construct(IUserListItemRepository $userListItemRepo)
    {
        $this->userListItemRepo = $userListItemRepo;
    }
}