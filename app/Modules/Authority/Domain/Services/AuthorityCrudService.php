<?

namespace App\Modules\Authority\Domain\Services;

use App\Modules\Authority\Domain\DTO\AuthorityDTO;
use App\Modules\Authority\Domain\Entities\AuthorityEntity;
use App\Modules\Authority\Domain\IRepository\IAuthorityRepository;

class AuthorityCrudService
{
    public function __construct(
        private IAuthorityRepository $authorityRepo
    ) {}

    /**
     * Returns all authority data
     * 
     * @return array||null
     */
    public function getAll(): ?array
    {
        return $this->authorityRepo->getAll()->all();
    }

    /**
     * Returns authority according to given id
     * 
     * @param int $id
     * @return AuthorityEntity||null
     */
    public function getById(int $id): ?AuthorityEntity
    {
        return $this->authorityRepo->getById($id);
    }

    /**
     * Creates a authority according to given data
     * 
     * @param AuthorityDTO $authorityDTO
     * @return AuthorityEntity||null
     */
    public function create(AuthorityDTO $authorityDTO): ?AuthorityEntity
    {
        return $this->authorityRepo->create($authorityDTO->toArray());
    }

    /**
     * Update a authority according to given data
     * 
     * @param int $id
     * @param AuthorityDTO $authorityDTO
     * @return AuthorityEntity||null
     */
    public function update(int $id, AuthorityDTO $authorityDTO): ?AuthorityEntity
    {
        $authority = $this->authorityRepo->getById($id);

        if (!$authority) {
            return null;
        }
        return $this->authorityRepo->update($authority, $authorityDTO->toArray());
    }

    /**
     * Deletes a authority according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $authority = $this->authorityRepo->getById($id);

        if (!$authority) {
            return false;
        }
        return $this->authorityRepo->delete($authority);
    }
}
