<?

namespace App\Modules\UserListItem\Application\Manager;

use App\Modules\UserListItem\Domain\Services\UserListItemService;
use Exception;
use Illuminate\Support\Facades\Log;

class UserListItemManager
{
    private UserListItemService $userListItemService;

    public function __construct(UserListItemService $userListItemService)
    {
        $this->userListItemService = $userListItemService;
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
        $listItems = $this->userListItemService->create($userListItems);

        if(count($listItems) != count($userListItems)) {
            Log::alert("Userlistitems could not created.");
            throw new Exception("An error occured while adding new item list.", 400);
        }

        Log::info("UserlistItems are created.");
        return $listItems;
    }
}
