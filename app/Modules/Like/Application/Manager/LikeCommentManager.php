<?

namespace App\Modules\Like\Application\Manager;

use App\Modules\Like\Domain\DTO\LikeCommentDTO;
use App\Modules\Like\Domain\Services\LikeCommentCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class LikeCommentManager
{
    public function __construct(
        private LikeCommentCrudService $likeCommentCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a like comment if its not exists. Deletes is otherwise according to given data.
     * 
     * @param LikeCommentDTO $likeCommentDTO
     * 
     * @throws Exception
     */
    public function likeReverser(LikeCommentDTO $likeCommentDTO)
    {
        $likeComment = $this->likeCommentCrudService->findByAttributes($likeCommentDTO->toArray());

        if ($likeComment) {
            $this->likeCommentCrudService->delete($likeComment->id);
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
                //TO-DO Unlike is going to delete if is exist.
            } else {
                $isRecovered = $this->likeCommentCrudService->restore($trashedLikeComment->id);

                if (!$isRecovered) {
                    $this->logger->alert("Like comment could not recovered.");
                    throw new Exception("Like comment could not recovered.", 400);
                }

                $this->logger->info("Like comment {$trashedLikeComment->id} is recovered.");
                //TO-DO Unlike is going to delete if is exist.
            }
        }
    }
}
