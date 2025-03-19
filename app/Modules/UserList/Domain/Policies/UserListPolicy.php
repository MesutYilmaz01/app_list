<?

namespace App\Modules\UserList\Domain\Policies;

use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\Shared\Responses\Interface\IResponseType;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class UserListPolicy
{
    public function __construct(
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
    public function isOwner(UserEntity $user, UserListEntity $listsItem, int $listId): Response
    {
        try {
            $userList = $this->userListManager->show($listId, new IResponseType());
            if ($userList->getUserListEntity()->user_id != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$listId} user list -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
