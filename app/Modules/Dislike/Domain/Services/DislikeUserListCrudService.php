<?

namespace App\Modules\Dislike\Domain\Services;

use App\Modules\Dislike\Domain\DTO\DislikeUserListDTO;
use App\Modules\Dislike\Domain\Entities\DislikeUserListEntity;
use App\Modules\Dislike\Domain\IRepository\IDislikeUserListRepository;

class DislikeUserListCrudService
{
    public function __construct(
        private IDislikeUserListRepository $dislikeUserListRepo
    ) {}

    /**
     * Returns dislike user list according to attributes
     * 
     * @param array $attributes
     * @return DislikeUserListEntity||null
     */
    public function findByAttributes(array $attributes): ?DislikeUserListEntity
    {
        return $this->dislikeUserListRepo->findByAttributes($attributes);
    }

    /**
     * Returns only traashed dislike user list according to attributes
     * 
     * @param array $attributes
     * @return DislikeUserListEntity||null
     */
    public function findByAttributesOnlyTrashed(array $attributes): ?DislikeUserListEntity
    {
        return $this->dislikeUserListRepo->onlyTrashed()->findByAttributes($attributes);
    }

    /**
     * Creates a dislike user list according to given data
     * 
     * @param DislikeUserListDTO $dislikeUserListDTO
     * @return DislikeUserListEntity||null
     */
    public function create(DislikeUserListDTO $dislikeUserListDTO): ?DislikeUserListEntity
    {
        return $this->dislikeUserListRepo->create($dislikeUserListDTO->toArray());
    }

    /**
     * Deletes a dislike user list according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $dislikeUserList = $this->dislikeUserListRepo->getById($id);

        if (!$dislikeUserList) {
            return false;
        }
        return $this->dislikeUserListRepo->delete($dislikeUserList);
    }

    /**
     * Restores a like user list according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $dislikeUserList = $this->dislikeUserListRepo->getById($id);

        if (!$dislikeUserList) {
            return false;
        }
        return $this->dislikeUserListRepo->restore($dislikeUserList);
    }
}
