<?

namespace App\Modules\Authority\Domain\Policies;

use App\Modules\Authority\Application\Manager\UserAuthorityManager;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\Response\UserAuthorityAdminResponse;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Response\UserListAdminResponse;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class UserAuthorityPolicy
{
    public function __construct(
        private UserListManager $userListManager,
        private UserAuthorityManager $userAuthortiyManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given user list can be updated by the user.
     *
     * @param UserEntity $user
     * @param int $listId
     * @return bool
     *
     * @throws Exception
     */
    public function isOwner(UserEntity $user, UserAuthorityEntity $userAuthorityEntity, int $listId): Response
    {
        try {
            $userList = $this->userListManager->setResponseType(UserListAdminResponse::class)->show($listId);
            if ($userList["user_id"] != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$listId} user list -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }

    /**
     * Determine if the given user list can be updated by the user.
     *
     * @param UserEntity $user
     * @param int $userAuthorityId
     * @return bool
     *
     * @throws Exception
     */
    public function isOwnerUserAuthority(UserEntity $user, UserAuthorityEntity $userAuthorityEntity, int $userAuthorityId): Response
    {
        try {
            $userAuthority = $this->userAuthortiyManager->setResponseType(UserAuthorityAdminResponse::class)->getById($userAuthorityId);
            if ($userAuthority["owner_user"]["id"] != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$userAuthorityId} user authority -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
    public function test()
    {
        dd('OK-test');
    }
}
