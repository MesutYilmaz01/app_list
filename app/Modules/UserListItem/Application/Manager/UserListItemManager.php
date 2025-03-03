<?

namespace App\Modules\UserListItem\Application\Manager;

use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
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
     * Gets list item given id
     * 
     * @param int $listId
     * @return UserListsItemEntity||null
     */
    public function getById(int $listId): ?UserListsItemEntity
    {
        $userListsItem = $this->userListItemCrudService->getById($listId);
        
        if (!$userListsItem) {
            $this->logger->alert("List item could not find for {$listId}");
            throw new Exception("List item could not find.", 400);
        }

        $this->logger->info("List item searched for {$listId}");
        return $userListsItem;
    }

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
    public function createMultiple(array $userListItems): array
    {
        $listItems = $this->userListItemCrudService->createMultiple($userListItems);

        if (count($listItems) != count($userListItems)) {
            $this->logger->alert("Userlistitems could not created.");
            throw new Exception("An error occured while adding new item list.", 400);
        }

        $this->logger->info("UserlistItems are created.");
        return $listItems;
    }

    /**
     * Creates a user list according to given data
     * 
     * @param UserListItemDTO $userListItemDTO
     * @return UserListsItemEntity||null
     * 
     * @throws Exception
     */
    public function create(UserListItemDTO $userListItemDTO): ?UserListsItemEntity
    {
        $userListItem = $this->userListItemCrudService->create($userListItemDTO);

        if (!$userListItem) {
            $this->logger->alert("User list item could not created.");
            throw new Exception("User list item could not created.", 400);
        }

        $this->logger->info("User list item {$userListItem->id} is created.");
        return $userListItem;
    }

    /**
     * Updates a userlist according to given data
     * 
     * @param int $listItemId
     * @param UserListItemDTO $userListItemDTO
     * @return UserListsItemEntity||null
     */
    public function update(int $listItemId, UserListItemDTO $userListItemDTO): ?UserListsItemEntity
    {
        $userListItem = $this->userListItemCrudService->update($listItemId, $userListItemDTO);

        if(!$userListItem) {
            $this->logger->alert("User list item {$listItemId} could not updated.");
            throw new Exception("User list item could not updated.", 400);
        }

        $this->logger->info("User list item {$userListItem->id} is updated.");
        return $userListItem;
    }

    /**
     * Deletes a user list item according to given id
     * 
     * @param int $listItemId
     * @return bool
     * 
     * @throws Exception
     */
    public function delete(int $listItemId): bool
    {
        $isDeleted = $this->userListItemCrudService->delete($listItemId);

        if (!$isDeleted) {
            $this->logger->alert("User list item {$listItemId} could not deleted.");
            throw new Exception("User list item could not deleted.", 400);
        }

        $this->logger->info("User list item {$listItemId} is deleted.");
        return $isDeleted;
    }
}
