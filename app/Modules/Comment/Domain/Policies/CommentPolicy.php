<?

namespace App\Modules\Comment\Domain\Policies;

use App\Modules\Comment\Application\Manager\CommentManager;
use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\Response\CommentAdminResponse;
use App\Modules\User\Domain\Entities\UserEntity;
use Exception;
use Illuminate\Auth\Access\Response;
use Psr\Log\LoggerInterface;

class CommentPolicy
{
    public function __construct(
        private CommentManager $commentManager,
        private LoggerInterface $logger
    ) {}

    /**
     * Determine if the given comment can be updated by the user.
     * 
     * @param CommentEntity $comment
     * @param int $commentId
     * @return bool
     * 
     * @throws Exception
     */
    public function isOwner(UserEntity $user, CommentEntity $comment, int $commentId): Response
    {
        try {
            $comment = $this->commentManager->setResponseType(CommentAdminResponse::class)->show($commentId);
            if ($comment["user_id"] != $user->id) {
                return Response::deny("Unauthenticated.", 403);
            }

            return Response::allow();
        } catch (Exception $e) {
            $this->logger->alert("Authentication policy problem for {$commentId} comment -> Message : " . $e->getMessage());
            return Response::deny($e->getMessage(), 403);
        }
    }
}
