<?

namespace App\Modules\UserListItem\Application\Manager;

use App\Modules\UserListItem\Domain\Services\UserListItemCrudService;
use Exception;
use Illuminate\Support\Facades\Log;

class UserListItemManager
{
    public function __construct(
        private UserListItemCrudService $userListItemCrudService
    ) {}

    /**
     * Gets all lists sub lists for given id
     * 
     * @param int $listId
     * @return array||null
     */
    public function getAllForGivenList(int $listId): ?array
    {
        $userListsItems = $this->userListItemCrudService->getAllForLists($listId);
        
        if (!$userListsItems) {
            Log::alert("Userlist sub lists could not find for {$listId} user.");
            throw new Exception("Userlists sub lists could not find.", 400);
        }

        Log::info("Userlist sub lists are searched for {$listId} lists.");
        return $userListsItems;
    }

    /**
     * Creates list items according to given array
     * 
     * @param array $userListItems
     * @return array
     * 
     * @throws Exception
     */
    public function create(array $userListItems): array
    {
        $listItems = $this->userListItemCrudService->create($userListItems);

        if (count($listItems) != count($userListItems)) {
            Log::alert("Userlistitems could not created.");
            throw new Exception("An error occured while adding new item list.", 400);
        }

        Log::info("UserlistItems are created.");
        return $listItems;
    }
}
