<?

namespace App\Modules\UserListItem\Domain\Policies;

use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Response\UserListAdminResponse;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use App\Modules\UserListItem\Domain\Response\UserListItemAdminResponse;
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
     * Determine if the given user list item can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $listItemId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwnerListItem(UserEntity $user, UserListsItemEntity $listsItem, int $listItemId): Response
    {
        try {
            $userListItem = $this->userListItemManager->setResponseType(UserListItemAdminResponse::class)->show($listItemId);
            $userList =  $this->userListManager->setResponseType(UserListAdminResponse::class)->show($userListItem["user_list_id"]);

            if ($userList["user_id"] != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$listItemId} user list item -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }

    /**
     * Determine if the given user list item can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $listItemId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwnerUserList(UserEntity $user, UserListsItemEntity $listsItem, int $userListId): Response
    {
        try {
            $userList =  $this->userListManager->setResponseType(UserListAdminResponse::class)->show($userListId);

            if ($userList["user_id"] != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$userListId} user list -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
