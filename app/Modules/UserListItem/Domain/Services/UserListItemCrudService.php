<?

namespace App\Modules\UserListItem\Domain\Services;

use App\Modules\UserListItem\Domain\Enums\StatusType;
use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;

class UserListItemCrudService
{
    public function __construct(
        private IUserListItemRepository $userListItemRepo
    ) {}

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
    public function create(array $userListItems): array
    {
        $tempUserListItems = [];

        foreach ($userListItems as $userListItem) {
            array_push($tempUserListItems, $this->userListItemRepo->create($userListItem->toArray()));
        }

        return $tempUserListItems;
    }
}
