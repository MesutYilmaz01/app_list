<?

namespace App\Modules\Like\Domain\Policies;

use App\Modules\Like\Application\Manager\LikeCommentManager;
use App\Modules\Like\Domain\Entities\LikeCommentEntity;
use App\Modules\User\Domain\Entities\UserEntity;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class LikeCommentPolicy
{
    public function __construct(
        private LikeCommentManager $likeCommentManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given user list can be updated by the user.
     * 
     * @param UserEntity $user
     * @param int $commentId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwner(UserEntity $user, LikeCommentEntity $likeComment, int $commentId): Response
    {
        try {
            $userId = auth()->user()->id;
            $likeComment = $this->likeCommentManager->findByAttributes([
                "comment_id" => $commentId,
                "user_id" => $userId
            ]);

            if ($likeComment->user_id != $userId) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for comment {$commentId} and user {$userId} like comment -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
