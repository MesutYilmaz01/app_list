<?

namespace App\Modules\Authority\Domain\Services;

use App\Modules\Authority\Domain\DTO\UserAuthorityDTO;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\IRepository\IUserAuthorityRepository;

class UserAuthorityCrudService
{
    public function __construct(
        private IUserAuthorityRepository $userAuthorityRepo
    ) {}

    /**
     * Returns user authority according to given id
     * 
     * @param int $id
     * @return UserAuthorityEntity||null
     */
    public function getById(int $id): ?UserAuthorityEntity
    {
        return $this->userAuthorityRepo->getById($id);
    }

    /**
     * Returns user authority with trashed according to given attributes
     * 
     * @param array $attributes
     * @return UserAuthorityEntity||null
     */
    public function findByAttributesWithTrashed(array $attributes): ?UserAuthorityEntity
    {
        return $this->userAuthorityRepo->withTrashed()->findByAttributes($attributes);
    }

    /**
     * Returns user authority according to given attributes
     * 
     * @param array $attributes
     * @return array
     */
    public function getAllByAttributes(array $attributes): array
    {
        return $this->userAuthorityRepo->getAllByAttributes($attributes)->toArray();
    }

    /**
     * Creates a user authority according to given data
     * 
     * @param UserAuthorityDTO $userAuthorityDTO
     * @return UserAuthorityEntity||null
     */
    public function create(UserAuthorityDTO $userAuthorityDTO): ?UserAuthorityEntity
    {
        return $this->userAuthorityRepo->create($userAuthorityDTO->toArray());
    }

    /**
     * Update a user authority according to given data
     * 
     * @param int $id
     * @param UserAuthorityDTO $userAuthorityDTO
     * @return UserAuthorityEntity||null
     */
    public function update(int $id, UserAuthorityDTO $userAuthorityDTO): ?UserAuthorityEntity
    {
        $userAuthority = $this->userAuthorityRepo->getById($id);

        if (!$userAuthority) {
            return null;
        }
        return $this->userAuthorityRepo->update($userAuthority, $userAuthorityDTO->toArray());
    }

    /**
     * Deletes a user authority according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $userAuthority = $this->userAuthorityRepo->getById($id);

        if (!$userAuthority) {
            return false;
        }
        return $this->userAuthorityRepo->delete($userAuthority);
    }

    /**
     * Restore a user authority according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $userAuthority = $this->userAuthorityRepo->getById($id);

        if (!$userAuthority) {
            return false;
        }
        return $this->userAuthorityRepo->restore($userAuthority);
    }
}
