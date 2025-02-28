<?

namespace App\Modules\UserListItem\Application\Manager;

use App\Modules\UserListItem\Domain\Services\UserListItemCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class UserListItemManager
{
    public function __construct(
        private UserListItemCrudService $userListItemCrudService,
        private LoggerInterface $logger
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
            $this->logger->alert("Userlist sub lists could not find for {$listId} user.");
            throw new Exception("Userlists sub lists could not find.", 400);
        }

        $this->logger->info("Userlist sub lists are searched for {$listId} lists.");
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
            $this->logger->alert("Userlistitems could not created.");
            throw new Exception("An error occured while adding new item list.", 400);
        }

        $this->logger->info("UserlistItems are created.");
        return $listItems;
    }
}
