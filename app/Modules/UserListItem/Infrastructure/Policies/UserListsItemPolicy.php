<?

namespace App\Modules\UserListItem\Infrastructure\Policies;

use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class UserListsItemPolicy
{
    public function __construct(
        private UserListItemManager $userListItemManager,
        private UserListManager $userListManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given user list can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $listItemId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwner(UserEntity $user, UserListsItemEntity $listsItem, int $listItemId): Response
    {
        try {
            $userListItem = $this->userListItemManager->getById($listItemId);
            $userList = $this->userListManager->show($userListItem->user_list_id);

            if ($userList->getUserListEntity()->user_id != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$listItemId} user list item -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
