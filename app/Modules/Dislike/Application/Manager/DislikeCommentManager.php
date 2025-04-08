<?

namespace App\Modules\Dislike\Application\Manager;

use App\Modules\Dislike\Domain\DTO\DislikeCommentDTO;
use App\Modules\Dislike\Domain\Entities\DislikeCommentEntity;
use App\Modules\Dislike\Domain\Services\DislikeCommentCrudService;
use App\Modules\Like\Domain\Services\LikeCommentCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class DislikeCommentManager
{
    public function __construct(
        private DislikeCommentCrudService $dislikeCommentCrudService,
        private LikeCommentCrudService $likeCommentCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a dislike comment if its not exists. Deletes is otherwise according to given data.
     * 
     * @param DislikeCommentDTO $dislikeCommentDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function dislikeReverser(DislikeCommentDTO $dislikeCommentDTO): bool
    {
        $dislikeComment = $this->dislikeCommentCrudService->findByAttributes($dislikeCommentDTO->toArray());

        if ($dislikeComment) {
            $this->dislikeCommentCrudService->delete($dislikeComment->id);
            return false;
        }

        if (!$dislikeComment) {
            $trashedDislikeComment = $this->dislikeCommentCrudService->findByAttributesOnlyTrashed($dislikeCommentDTO->toArray());

            if (!$trashedDislikeComment) {
                $newLikeComment = $this->dislikeCommentCrudService->create($dislikeCommentDTO);

                if (!$newLikeComment) {
                    $this->logger->alert("Dislike comment could not created.");
                    throw new Exception("Dislike comment could not created.", 400);
                }

                $this->logger->info("Dislike comment {$newLikeComment->id} is created.");
            } else {
                $isRecovered = $this->dislikeCommentCrudService->restore($trashedDislikeComment->id);

                if (!$isRecovered) {
                    $this->logger->alert("Dislike comment could not recovered.");
                    throw new Exception("Dislike comment could not recovered.", 400);
                }

                $this->logger->info("Like comment {$trashedDislikeComment->id} is recovered.");
            }

            $likeComment = $this->likeCommentCrudService->findByAttributes($dislikeCommentDTO->toArray());

            if ($likeComment) {
                $this->likeCommentCrudService->delete($likeComment->id);
                $this->logger->info("Like comment {$likeComment->id} is deleted.");
            }
        }

        return true;
    }

    /**
     * Returns dislike comment according to attributes
     * 
     * @param array $attributes
     * @return DislikeCommentEntity||null
     */
    public function findByAttributes(array $attributes): ?DislikeCommentEntity
    {
        return $this->dislikeCommentCrudService->findByAttributes($attributes);
    }
}
