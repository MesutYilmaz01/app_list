<?

namespace App\Modules\Like\Application\Manager;

use App\Modules\Like\Domain\DTO\LikeUserListDTO;
use App\Modules\Like\Domain\Services\LikeUserListCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class LikeUserListManager
{
    public function __construct(
        private LikeUserListCrudService $likeUserListCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a like user list if its not exists. Deletes is otherwise according to given data.
     * 
     * @param LikeUserListDTO $LikeUserListDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function likeReverser(LikeUserListDTO $LikeUserListDTO): bool
    {
        $likeUserList = $this->likeUserListCrudService->findByAttributes($LikeUserListDTO->toArray());

        if ($likeUserList) {
            $this->likeUserListCrudService->delete($likeUserList->id);
            return false;
        }

        if (!$likeUserList) {
            $trashedLikeUserList = $this->likeUserListCrudService->findByAttributesOnlyTrashed($LikeUserListDTO->toArray());

            if (!$trashedLikeUserList) {
                $newLikeUserList = $this->likeUserListCrudService->create($LikeUserListDTO);

                if (!$newLikeUserList) {
                    $this->logger->alert("Like user list could not created.");
                    throw new Exception("Like user list could not created.", 400);
                }

                $this->logger->info("Like user list {$newLikeUserList->id} is created.");
                //TO-DO Unlike is going to delete if is exist.
            } else {
                $isRecovered = $this->likeUserListCrudService->restore($trashedLikeUserList->id);

                if (!$isRecovered) {
                    $this->logger->alert("Like user list could not recovered.");
                    throw new Exception("Like user list could not recovered.", 400);
                }

                $this->logger->info("Like user list {$trashedLikeUserList->id} is recovered.");
                //TO-DO Unlike is going to delete if is exist.
            }
        }

        return true;
    }
}
