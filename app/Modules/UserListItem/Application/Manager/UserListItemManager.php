<?

namespace App\Modules\UserListItem\Application\Manager;

use App\Modules\UserListItem\Domain\Services\UserListItemCrudService;
use Exception;
use Illuminate\Support\Facades\Log;

class UserListItemManager
{
    private UserListItemCrudService $userListItemCrudService;

    public function __construct(UserListItemCrudService $userListItemCrudService)
    {
        $this->userListItemCrudService = $userListItemCrudService;
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

        if(count($listItems) != count($userListItems)) {
            Log::alert("Userlistitems could not created.");
            throw new Exception("An error occured while adding new item list.", 400);
        }

        Log::info("UserlistItems are created.");
        return $listItems;
    }
}
