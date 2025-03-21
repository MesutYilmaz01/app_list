<?

namespace App\Modules\UserList\Application\Manager;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\Services\UserListCrudService;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;
use Psr\Log\LoggerInterface;

class UserListManager
{
    public function __construct(
        private UserListCrudService $userListCrudService,
        private UserListItemManager $userListItemManager,
        private UserListAggregate   $userListAggregate,
        private LoggerInterface     $logger
    ) {}

    /**
     * Gets all user lists for given id
     *
     * @param int $userId
     * @return array||null
     */
    public function getAllForUser(int $userId): ?array
    {
        $userLists = $this->userListCrudService->getAllForUser($userId);

        if (!$userLists) {
            $this->logger->alert("Userlist could not find for {$userId} user.");
            throw new Exception("Userlists could not find.", 400);
        }

        $this->logger->info("Userlist is searched for {$userId} user.");
        return $userLists;
    }

    /**
     * Gets all lists according to given filter attributes.
     *
     * @param array $filterParams
     * @return array||null
     */
    public function get(array $filterParams): ?array
    {
        $lists = $this->userListCrudService->get($filterParams);

        if (!$lists) {
            $this->logger->alert("List could not found for this attributes.");
            throw new Exception("List could not found for this attributes.", 400);
        }

        $this->logger->info("List found for this attributes.");
        return $lists;
    }

    /**
     * Gets a user list for given id
     *
     * @param int $listId
     * @return array
     * 
     * @throws Exception
     */
    public function show(int $listId): array
    {
        $userList = $this->userListCrudService->show($listId);

        if (!$userList) {
            $this->logger->alert("Userlist could not find for {$listId} list.");
            throw new Exception("Userlist could not find.", 400);
        }

        $this->logger->info("Userlist {$listId} is searched.");

        $this->userListAggregate->setUserListEntity($userList);

        return $this->userListAggregate->getResponseType()->fill();
    }

    /**
     * Creates a userlist according to given data
     *
     * @param UserListDTO $userListDTO
     * @return UserListEntity||null
     *
     * @throws Exception
     */
    public function create(UserListDTO $userListDTO): ?UserListEntity
    {
        $userList = $this->userListCrudService->create($userListDTO);

        if (!$userList) {
            $this->logger->alert("Userlist could not created.");
            throw new Exception("Userlist could not created.", 400);
        }

        $this->logger->info("Userlist {$userList->id} is created.");

        return $userList;
    }

    /**
     * Updates a userlist according to given data
     *
     * @param int $listId
     * @param userListDTO $userListDTO
     * @return UserListEntity||null
     */
    public function update(int $listId, UserListDTO $userListDTO): ?UserListEntity
    {
        $userList = $this->userListCrudService->update($listId, $userListDTO);

        if (!$userList) {
            $this->logger->alert("Userlist {$listId} could not updated.");
            throw new Exception("Userlist could not updated.", 400);
        }

        $this->logger->info("Userlist {$userList->id} is updated.");
        return $userList;
    }

    /**
     * Deletes a user list according to given id
     *
     * @param int $listId
     * @return bool
     *
     * @throws Exception
     */
    public function delete(int $listId): bool
    {
        $isDeleted = $this->userListCrudService->delete($listId);

        if (!$isDeleted) {
            $this->logger->alert("Userlist {$listId} could not deleted.");
            throw new Exception("Userlist could not deleted.", 400);
        }

        $this->logger->info("Userlist {$listId} is deleted.");
        return $isDeleted;
    }

    /**
     * Sets response type of user list aggregate
     * 
     * @param class-string<IBaseResponse> $responseTypeName
     * @return UserListManager
     */
    public function setResponseType(string $responseTypeName): UserListManager
    {
        $this->userListAggregate->setResponseType(app($responseTypeName));
        return $this;
    }
}
