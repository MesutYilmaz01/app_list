<?

namespace App\Modules\Like\Domain\Policies;

use App\Modules\Like\Application\Manager\LikeUserListManager;
use App\Modules\Like\Domain\Entities\LikeUserListEntity;
use App\Modules\User\Domain\Entities\UserEntity;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class LikeUserListPolicy
{
    public function __construct(
        private LikeUserListManager $likeUserListManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given user list can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $userListId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwner(UserEntity $user, LikeUserListEntity $likeUserList, int $userListId): Response
    {
        try {
            $userId = auth()->user()->id;
            $likeUserList = $this->likeUserListManager->findByAttributes([
                "user_list_id" => $userListId,
                "user_id" => $userId
            ]);

            if ($likeUserList->user_id != $userId) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for user list {$userListId} and user {$userId} like comment -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
