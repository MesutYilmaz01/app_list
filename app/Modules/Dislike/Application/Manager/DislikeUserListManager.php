<?

namespace App\Modules\Dislike\Application\Manager;

use App\Modules\Dislike\Domain\DTO\DislikeUserListDTO;
use App\Modules\Dislike\Domain\Services\DislikeUserListCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class DislikeUserListManager
{
    public function __construct(
        private DislikeUserListCrudService $dislikeUserListCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a dislike user list if its not exists. Deletes is otherwise according to given data.
     * 
     * @param DislikeUserListDTO $dislikeUserListDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function dislikeReverser(DislikeUserListDTO $dislikeUserListDTO): bool
    {
        $dislikeUserList = $this->dislikeUserListCrudService->findByAttributes($dislikeUserListDTO->toArray());

        if ($dislikeUserList) {
            $this->dislikeUserListCrudService->delete($dislikeUserList->id);
            return false;
        }

        if (!$dislikeUserList) {
            $trashedDislikeUserList = $this->dislikeUserListCrudService->findByAttributesOnlyTrashed($dislikeUserListDTO->toArray());

            if (!$trashedDislikeUserList) {
                $newDislikeUserList = $this->dislikeUserListCrudService->create($dislikeUserListDTO);

                if (!$newDislikeUserList) {
                    $this->logger->alert("Dislike user list could not created.");
                    throw new Exception("Dislike user list could not created.", 400);
                }

                $this->logger->info("Dislike user list {$newDislikeUserList->id} is created.");
                //TO-DO Unlike is going to delete if is exist.
            } else {
                $isRecovered = $this->dislikeUserListCrudService->restore($trashedDislikeUserList->id);

                if (!$isRecovered) {
                    $this->logger->alert("Dislike user list could not recovered.");
                    throw new Exception("Dislike user list could not recovered.", 400);
                }

                $this->logger->info("Dislike user list {$trashedDislikeUserList->id} is recovered.");
                //TO-DO Unlike is going to delete if is exist.
            }
        }

        return true;
    }
}
