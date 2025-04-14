<?

namespace App\Modules\Authority\Application\Manager;

use App\Modules\Authority\Domain\Aggregate\AuthorityAggregate;
use App\Modules\Authority\Domain\DTO\AuthorityDTO;
use App\Modules\Authority\Domain\Entities\AuthorityEntity;
use App\Modules\Authority\Domain\Services\AuthorityCrudService;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use Exception;
use Psr\Log\LoggerInterface;

class AuthorityManager
{
    public function __construct(
        private AuthorityCrudService $authorityCrudService,
        private AuthorityAggregate $authorityAggregate,
        private LoggerInterface $logger
    ) {}

    /**
     * Returns all category data
     * 
     * @return array
     * 
     * @throws Exception
     */
    public function getAll(): array
    {
        $authorities = $this->authorityCrudService->getAll();

        if (!$authorities) {
            $this->logger->alert("Authorities could not listed.");
            throw new Exception("Authorities are not listed.", 404);
        }

        $this->logger->info("Authorities are listed.");

        $this->authorityAggregate->setAuthorityList($authorities);
        return $this->authorityAggregate->getResponseType()->fill();
    }

    /**
     * Returns AuthorityEntity according to given id
     * 
     * @param int $id
     * @return array
     * 
     * @throws Exception
     */
    public function getById(int $id): array
    {
        $authority = $this->authorityCrudService->getById($id);

        if (!$authority) {

            $this->logger->alert("Authority {$id} could not listed.");
            throw new Exception("Authority could not found.", 404);
        }

        $this->logger->info("Authority {$id} is listed.");

        $this->authorityAggregate->setAuthorityEntity($authority);
        return $this->authorityAggregate->getResponseType()->fill();
    }

    /**
     * Creates a authority according to given data
     * 
     * @param AuthorityDTO $authorityDTO
     * @return AuthorityEntity||null
     * 
     * @throws Exception
     */
    public function create(AuthorityDTO $authorityDTO): ?AuthorityEntity
    {
        $authority = $this->authorityCrudService->create($authorityDTO);

        if (!$authority) {
            $this->logger->alert("Authority could not created.");
            throw new Exception("Authority could not created.", 400);
        }

        $this->logger->info("Authority {$authority->id} is created.");
        return $authority;
    }

    /**
     * Update a authority according to given data
     * 
     * @param int $id
     * @param AuthorityDTO $authorityDTO
     * @return AuthorityEntity||null
     * 
     * @throws Exception
     */
    public function update(int $id, AuthorityDTO $authorityDTO): ?AuthorityEntity
    {
        $authority = $this->authorityCrudService->update($id, $authorityDTO);

        if (!$authority) {
            $this->logger->alert("Authority {$id} could not updated.");
            throw new Exception("Authority could not updated.", 400);
        }

        $this->logger->info("Authority {$id} is updated.");
        return $authority;
    }

    /**
     * Deletes a authority according to given id
     * 
     * @param int $id
     * @return bool
     * 
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $isDeleted = $this->authorityCrudService->delete($id);

        if (!$isDeleted) {
            $this->logger->alert("Authority {$id} could not deleted.");
            throw new Exception("Authority could not deleted.", 400);
        }

        $this->logger->info("Authority {$id} is deleted.");
        return $isDeleted;
    }

    /**
     * Sets response type of user authority aggregate
     * 
     * @param class-string<IBaseResponse> $responseTypeName
     * @return AuthorityManager
     */
    public function setResponseType(string $responseTypeName): AuthorityManager
    {
        $this->authorityAggregate->setResponseType(app($responseTypeName));
        return $this;
    }
}
