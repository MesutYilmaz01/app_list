<?

namespace App\Modules\Like\Application\Manager;

use App\Modules\Dislike\Domain\Services\DislikeUserListCrudService;
use App\Modules\Like\Domain\DTO\LikeUserListDTO;
use App\Modules\Like\Domain\Entities\LikeUserListEntity;
use App\Modules\Like\Domain\Services\LikeUserListCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class LikeUserListManager
{
    public function __construct(
        private LikeUserListCrudService $likeUserListCrudService,
        private DislikeUserListCrudService $dislikeUserListCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a like user list if its not exists. Deletes is otherwise according to given data.
     * 
     * @param LikeUserListDTO $likeUserListDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function likeReverser(LikeUserListDTO $likeUserListDTO): bool
    {
        $likeUserList = $this->likeUserListCrudService->findByAttributes($likeUserListDTO->toArray());

        if ($likeUserList) {
            $this->likeUserListCrudService->delete($likeUserList->id);
            return false;
        }

        if (!$likeUserList) {
            $trashedLikeUserList = $this->likeUserListCrudService->findByAttributesOnlyTrashed($likeUserListDTO->toArray());

            if (!$trashedLikeUserList) {
                $newLikeUserList = $this->likeUserListCrudService->create($likeUserListDTO);

                if (!$newLikeUserList) {
                    $this->logger->alert("Like user list could not created.");
                    throw new Exception("Like user list could not created.", 400);
                }

                $this->logger->info("Like user list {$newLikeUserList->id} is created.");
            } else {
                $isRecovered = $this->likeUserListCrudService->restore($trashedLikeUserList->id);

                if (!$isRecovered) {
                    $this->logger->alert("Like user list could not recovered.");
                    throw new Exception("Like user list could not recovered.", 400);
                }

                $this->logger->info("Like user list {$trashedLikeUserList->id} is recovered.");
            }

            $dislikeUserList = $this->dislikeUserListCrudService->findByAttributes($likeUserListDTO->toArray());

            if ($dislikeUserList) {
                $this->dislikeUserListCrudService->delete($dislikeUserList->id);
                $this->logger->info("Dislike user list {$dislikeUserList->id} is deleted.");
            }
        }

        return true;
    }

    /**
     * Returns like user list according to attributes
     * 
     * @param array $attributes
     * @return LikeUserListEntity||null
     */
    public function findByAttributes(array $attributes): ?LikeUserListEntity
    {
        return $this->likeUserListCrudService->findByAttributes($attributes);
    }
}
