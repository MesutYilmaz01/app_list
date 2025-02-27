<?

namespace App\Modules\UserListItem\Domain\Services;

use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;
use Illuminate\Database\Eloquent\Collection;

class UserListItemCrudService
{
    public IUserListItemRepository $userListItemRepo;
    
    public function __construct(IUserListItemRepository $userListItemRepo)
    {
        $this->userListItemRepo = $userListItemRepo;
    }

    /**
     * Gets all user lists sub lists for given list id
     * 
     * @param int $listId
     * @return Collection||null
     */
    public function getAllForLists(int $listId): ?Collection
    {
        return $this->userListItemRepo->getAllByAttributes(['id' => $listId]);
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