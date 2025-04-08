<?

namespace App\Modules\Like\Application\Manager;

use App\Modules\Dislike\Domain\Services\DislikeCommentCrudService;
use App\Modules\Like\Domain\DTO\LikeCommentDTO;
use App\Modules\Like\Domain\Entities\LikeCommentEntity;
use App\Modules\Like\Domain\Services\LikeCommentCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class LikeCommentManager
{
    public function __construct(
        private LikeCommentCrudService $likeCommentCrudService,
        private DislikeCommentCrudService $dislikeCommentCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a like comment if its not exists. Deletes is otherwise according to given data.
     * 
     * @param LikeCommentDTO $likeCommentDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function likeReverser(LikeCommentDTO $likeCommentDTO): bool
    {
        $likeComment = $this->likeCommentCrudService->findByAttributes($likeCommentDTO->toArray());

        if ($likeComment) {
            $this->likeCommentCrudService->delete($likeComment->id);
            return false;
        }

        if (!$likeComment) {
            $trashedLikeComment = $this->likeCommentCrudService->findByAttributesOnlyTrashed($likeCommentDTO->toArray());

            if (!$trashedLikeComment) {
                $newLikeComment = $this->likeCommentCrudService->create($likeCommentDTO);

                if (!$newLikeComment) {
                    $this->logger->alert("Like comment could not created.");
                    throw new Exception("Like comment could not created.", 400);
                }

                $this->logger->info("Like comment {$newLikeComment->id} is created.");
            } else {
                $isRecovered = $this->likeCommentCrudService->restore($trashedLikeComment->id);

                if (!$isRecovered) {
                    $this->logger->alert("Like comment could not recovered.");
                    throw new Exception("Like comment could not recovered.", 400);
                }

                $this->logger->info("Like comment {$trashedLikeComment->id} is recovered.");
            }

            $dislikeComment = $this->dislikeCommentCrudService->findByAttributes($likeCommentDTO->toArray());

            if ($dislikeComment) {
                $this->dislikeCommentCrudService->delete($dislikeComment->id);
                $this->logger->info("Dislike comment {$dislikeComment->id} is deleted.");
            }
        }

        return true;
    }

    /**
     * Returns like comment according to attributes
     * 
     * @param array $attributes
     * @return LikeCommentEntity||null
     */
    public function findByAttributes(array $attributes): ?LikeCommentEntity
    {
        return $this->likeCommentCrudService->findByAttributes($attributes);
    }
}
