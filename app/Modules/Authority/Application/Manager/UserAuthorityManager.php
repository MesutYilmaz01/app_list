<?

namespace App\Modules\Authority\Application\Manager;

use App\Modules\Authority\Domain\DTO\UserAuthorityDTO;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\Services\UserAuthorityCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class UserAuthorityManager
{
    public function __construct(
        private UserAuthorityCrudService $userAuthorityCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Returns UserAuthorityEntity according to given id
     * 
     * @param int $id
     * @return UserAuthorityEntity||null
     * 
     * @throws Exception
     */
    public function getById(int $id): ?UserAuthorityEntity
    {
        $userAuthority = $this->userAuthorityCrudService->getById($id);

        if (!$userAuthority) {
            $this->logger->alert("User authority {$id} could not listed.");
            throw new Exception("User authority could not found.", 404);
        }

        $this->logger->info("User authority {$id} is listed.");
        return $userAuthority;
    }

    /**
     * Creates a user authority according to given data
     * 
     * @param UserAuthorityDTO $userAuthorityDTO
     * @return UserAuthorityEntity||null
     * 
     * @throws Exception
     */
    public function create(UserAuthorityDTO $userAuthorityDTO): ?UserAuthorityEntity
    {
        $userAuthority = $this->userAuthorityCrudService->create($userAuthorityDTO);

        if (!$userAuthority) {
            $this->logger->alert("User authority could not created.");
            throw new Exception("User authority could not created.", 400);
        }

        $this->logger->info("User authority {$userAuthority->id} is created.");
        return $userAuthority;
    }

    /**
     * Update a user authority according to given data
     * 
     * @param int $id
     * @param UserAuthorityDTO $userAuthorityDTO
     * @return UserAuthorityEntity||null
     * 
     * @throws Exception
     */
    public function update(int $id, UserAuthorityDTO $userAuthorityDTO): ?UserAuthorityEntity
    {
        $userAuthority = $this->userAuthorityCrudService->update($id, $userAuthorityDTO);

        if (!$userAuthority) {
            $this->logger->alert("User authority {$id} could not updated.");
            throw new Exception("User authority could not updated.", 400);
        }

        $this->logger->info("User authority {$id} is updated.");
        return $userAuthority;
    }

    /**
     * Deletes a user authority according to given id
     * 
     * @param int $id
     * @return bool
     * 
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $isDeleted = $this->userAuthorityCrudService->delete($id);

        if (!$isDeleted) {
            $this->logger->alert("User authority {$id} could not deleted.");
            throw new Exception("User authority could not deleted.", 400);
        }

        $this->logger->info("User authority {$id} is deleted.");
        return $isDeleted;
    }
}
