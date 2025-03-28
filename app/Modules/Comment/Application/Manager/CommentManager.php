<?

namespace App\Modules\Comment\Application\Manager;

use App\Modules\Comment\Domain\Aggregate\CommentAggregate;
use App\Modules\Comment\Domain\DTO\CommentDTO;
use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\Services\CommentCrudService;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use Exception;
use Psr\Log\LoggerInterface;

class CommentManager
{
    public function __construct(
        private CommentCrudService $commentCrudService,
        private CommentAggregate $commentAggregate,
        private LoggerInterface $logger
    ) {}

    /**
     * Returns CommentEntity according to given id
     * 
     * @param int $commentId
     * @return array
     * 
     * @throws Exception
     */
    public function show(int $commentId): array
    {
        $comment = $this->commentCrudService->show($commentId);

        if (!$comment) {

            $this->logger->alert("Comment {$commentId} could not listed.");
            throw new Exception("Comment could not found.", 404);
        }
        
        $this->logger->info("Comment {$commentId} is listed.");

        $this->commentAggregate->setCommentEntity($comment);

        return $this->commentAggregate->getResponseType()->fill();
    }

    /**
     * Creates a comment according to given data
     * 
     * @param CommentDTO $commentDTO
     * @return CommentEntity||null
     * 
     * @throws Exception
     */
    public function create(CommentDTO $commentDTO): ?CommentEntity
    {
        $comment = $this->commentCrudService->create($commentDTO);

        if (!$comment) {
            $this->logger->alert("Comment could not created.");
            throw new Exception("Comment could not created.", 400);
        }

        $this->logger->info("Comment {$comment->id} is created.");
        return $comment;
    }

    /**
     * Update a comment according to given data
     * 
     * @param int $commentId
     * @param CommentDTO $commentDTO
     * @return CommentEntity||null
     * 
     * @throws Exception
     */
    public function update(int $commentId, CommentDTO $commentDTO): ?CommentEntity
    {
        $comment = $this->commentCrudService->update($commentId, $commentDTO);

        if (!$comment) {
            $this->logger->alert("Comment {$commentId} could not updated.");
            throw new Exception("Comment could not updated.", 400);
        }

        $this->logger->info("Comment {$commentId} is updated.");
        return $comment;
    }

    /**
     * Deletes a comment according to given id
     * 
     * @param int $commentId
     * @return bool
     * 
     * @throws Exception
     */
    public function delete(int $commentId): bool
    {
        $isDeleted = $this->commentCrudService->delete($commentId);

        if (!$isDeleted) {
            $this->logger->alert("Comment {$commentId} could not deleted.");
            throw new Exception("Comment could not deleted.", 400);
        }

        $this->logger->info("Comment {$commentId} is deleted.");
        return $isDeleted;
    }

    /**
     * Sets response type of comment aggregate
     * 
     * @param class-string<IBaseResponse> $responseTypeName
     * @return CommentManager
     */
    public function setResponseType(string $responseTypeName): CommentManager
    {
        $this->commentAggregate->setResponseType(app($responseTypeName));
        return $this;
    }
}
