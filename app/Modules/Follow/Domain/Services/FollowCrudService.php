<?

namespace App\Modules\Follow\Domain\Services;

use App\Modules\Follow\Domain\DTO\FollowDTO;
use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Follow\Domain\IRepository\IFollowRepository;

class FollowCrudService
{
    public function __construct(
        private IFollowRepository $followRepository
    ) {}

    /**
     * Returns follow according to attributes
     * 
     * @param array $attributes
     * @return FollowEntity||null
     */
    public function findByAttributes(array $attributes): ?FollowEntity
    {
        return $this->followRepository->findByAttributes($attributes);
    }

    /**
     * Returns follows according to attributes
     * 
     * @param array $attributes
     * @return array
     */
    public function getAllByAttributes(array $attributes): array
    {
        return $this->followRepository->getAllByAttributes($attributes)->all();
    }

    /**
     * Returns only traashed follow according to attributes
     * 
     * @param array $attributes
     * @return FollowEntity||null
     */
    public function findByAttributesOnlyTrashed(array $attributes): ?FollowEntity
    {
        return $this->followRepository->onlyTrashed()->findByAttributes($attributes);
    }

    /**
     * Creates a follow according to given data
     * 
     * @param FollowDTO $dislikeCommentDTO
     * @return FollowEntity||null
     */
    public function create(FollowDTO $dislikeCommentDTO): ?FollowEntity
    {
        return $this->followRepository->create($dislikeCommentDTO->toArray());
    }

    /**
     * Deletes a follow according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $follow = $this->followRepository->getById($id);

        if (!$follow) {
            return false;
        }
        return $this->followRepository->delete($follow);
    }

    /**
     * Restores a follow according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $follow = $this->followRepository->getById($id);

        if (!$follow) {
            return false;
        }
        return $this->followRepository->restore($follow);
    }
}
