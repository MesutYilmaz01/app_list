<?

namespace App\Modules\UserList\Domain\Policies;

use App\Modules\Authority\Application\Manager\UserAuthorityManager;
use App\Modules\Authority\Domain\Enums\AuthorityType;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\Response\UserListAdminResponse;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class UserListPolicy
{
    public function __construct(
        private UserListManager $userListManager,
        private UserAuthorityManager $userAuthorityManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given user list can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $userListId
     * @param AuthorityType $authorityType
     * @return bool
     * 
     * @throws Exception
     */
    public function isAuthorized(UserEntity $user, UserListEntity $lists, int $userListId, AuthorityType $authorityType): Response
    {
        try {
            $userList = $this->userListManager->setResponseType(UserListAdminResponse::class)->show($userListId);
            $userAuthority = $this->userAuthorityManager->findByAttributes($userListId, auth()->user()->id);
            if ($userList["user_id"] != $user->id && (!is_null($userAuthority) && $userAuthority->authority->code < $authorityType->value)) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$userListId} user list -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
