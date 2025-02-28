<?

namespace App\Modules\UserList\Application\Manager;

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
        private UserListAggregate $userListAggregate,
        private LoggerInterface $logger
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
     * Gets a user list for given id
     * 
     * @param int $listId
     * @return UserListAggregate||null
     */
    public function show(int $listId): ?UserListAggregate
    {
        $userList = $this->userListCrudService->show($listId);

        if (!$userList) {
            $this->logger->alert("Userlist could not find for {$listId} list.");
            throw new Exception("Userlist could not find.", 400);
        }

        $userListsItems = $this->userListItemManager->getAllForGivenList($listId);

        if (!$userListsItems) {
            $this->logger->alert("Userlist sub items could not find for {$listId} list.");
            throw new Exception("Userlist sub items could not find.", 400);
        }

        $this->userListAggregate->setUserLitsItems($userListsItems);

        $this->logger->info("Userlist {$listId} is searched.");
        return $this->userListAggregate;
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
}
