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

    /**
     * Creates user list items according to given array
     * 
     * @param array $userListItems
     * 
     * @return array
     */
    public function create(array $userListItems): array
    {
        $tempUserListItems = [];
        
        foreach($userListItems as $userListItem) {
            array_push($tempUserListItems, $this->userListItemRepo->create($userListItem->toArray()));
        }

        return $tempUserListItems;
    }
}