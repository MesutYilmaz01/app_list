<?

namespace App\Modules\UserListItem\Domain\Services;

use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use App\Modules\UserListItem\Domain\Enums\StatusType;
use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;

class UserListItemCrudService
{
    public function __construct(
        private IUserListItemRepository $userListItemRepo
    ) {}

    /**
     * Gets list item given id
     * 
     * @param int $listId
     * @return UserListsItemEntity||null
     */
    public function getById(int $listId): ?UserListsItemEntity
    {
        return $this->userListItemRepo->getById($listId);
    }

    /**
     * Gets all user lists sub lists for given list id
     * 
     * @param int $listId
     * @return array||null
     */
    public function getAllForLists(int $listId): ?array
    {
        return $this->userListItemRepo->getAllByAttributes(['user_list_id' => $listId, 'status' => StatusType::ACTIVE->value])->toArray();
    }


    /**
     * Creates user list items according to given array
     * 
     * @param array $userListItems
     * 
     * @return array
     */
    public function createMultiple(array $userListItems): array
    {
        $tempUserListItems = [];

        foreach ($userListItems as $userListItem) {
            array_push($tempUserListItems, $this->userListItemRepo->create($userListItem->toArray()));
        }

        return $tempUserListItems;
    }

    /**
     * Creates a userlist item according to given dto
     * 
     * @param UserListItemDTO $userListItemDTO
     * @return UserListsItemEntity||null
     */
    public function create(UserListItemDTO $userListItemDTO): ?UserListsItemEntity
    {
        return $this->userListItemRepo->create($userListItemDTO->toArray());
    }

    /**
     * Updates a user list item according to given data
     * 
     * @param int $listItemId
     * @param userListDTO $userListDTO
     * @return UserListsItemEntity||null
     */
    public function update(int $listItemId, UserListItemDTO $userListItemDTO): ?UserListsItemEntity
    {
        $userListItem = $this->userListItemRepo->findByAttributes([
            'id' => $listItemId,
            'status' => StatusType::ACTIVE->value,
        ]);
        
        if(!$userListItem) {
            return null;
        }

        return $this->userListItemRepo->update($userListItem, $userListItemDTO->toArray());
    }

    /**
     * Deletes a user list item according to given id
     * 
     * @param int $listItemId
     * @return bool
     */
    public function delete(int $listItemId): bool
    {
        $userListItem = $this->userListItemRepo->getById($listItemId);

        if (!$userListItem) {
            return false;
        }

        return $this->userListItemRepo->delete($userListItem);
    }

    /**
     * Deletes user list items according to given id
     * 
     * @param int $userListItemId
     * @return bool
     */
    public function deleteMany(int $userListItemId): bool
    {
        $userListItems = $this->userListItemRepo->getAllByAttributes(["user_list_id" => $userListItemId]);
        
        if (!$userListItems) {
            return false;
        }

        return $this->userListItemRepo->deleteMany(["user_list_id"=> $userListItemId]);
    }
}
