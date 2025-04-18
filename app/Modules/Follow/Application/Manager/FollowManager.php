<?

namespace App\Modules\Follow\Application\Manager;

use App\Modules\Follow\Domain\DTO\FollowDTO;
use App\Modules\Follow\Domain\Services\FollowCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class FollowManager
{
    public function __construct(
        private FollowCrudService $followCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates or recovers a follow if its not exists. Deletes is otherwise according to given data.
     * 
     * @param FollowDTO $followDTO
     * @return bool
     * 
     * @throws Exception
     */
    public function followReverser(FollowDTO $followDTO): bool
    {
        if ($followDTO->getUserId() == $followDTO->getFollowedUserId()) {
            $this->logger->alert("User cant follow or unfollow itself.");
            throw new Exception("User cant follow or unfollow itself.", 400);
        }

        $follow = $this->followCrudService->findByAttributes($followDTO->toArray());

        if ($follow) {
            $this->followCrudService->delete($follow->id);
            return false;
        }

        if (!$follow) {
            $trashedFollow = $this->followCrudService->findByAttributesOnlyTrashed($followDTO->toArray());

            if (!$trashedFollow) {
                $newFollow = $this->followCrudService->create($followDTO);

                if (!$newFollow) {
                    $this->logger->alert("Follow could not created.");
                    throw new Exception("Follow could not created.", 400);
                }

                $this->logger->info("Follow {$newFollow->id} is created.");
            } else {
                $isRecovered = $this->followCrudService->restore($trashedFollow->id);

                if (!$isRecovered) {
                    $this->logger->alert("Follow could not recovered.");
                    throw new Exception("Follow could not recovered.", 400);
                }

                $this->logger->info("Follow {$trashedFollow->id} is recovered.");
            }
        }

        return true;
    }
}
