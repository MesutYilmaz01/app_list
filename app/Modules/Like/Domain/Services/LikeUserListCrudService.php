<?

namespace App\Modules\Like\Domain\Services;

use App\Modules\Like\Domain\DTO\LikeUserListDTO;
use App\Modules\Like\Domain\Entities\LikeUserListEntity;
use App\Modules\Like\Domain\IRepository\ILikeUserListRepository;

class LikeUserListCrudService
{
    public function __construct(
        private ILikeUserListRepository $likeUserListRepo
    ) {}

    /**
     * Returns like user list according to attributes
     * 
     * @param array $attributes
     * @return LikeUserListEntity||null
     */
    public function findByAttributes(array $attributes): ?LikeUserListEntity
    {
        return $this->likeUserListRepo->findByAttributes($attributes);
    }

    /**
     * Returns only traashed like user list according to attributes
     * 
     * @param array $attributes
     * @return LikeUserListEntity||null
     */
    public function findByAttributesOnlyTrashed(array $attributes): ?LikeUserListEntity
    {
        return $this->likeUserListRepo->onlyTrashed()->findByAttributes($attributes);
    }

    /**
     * Creates a like user list according to given data
     * 
     * @param LikeUserListDTO $likeUserListDTO
     * @return LikeCommentEntity||null
     */
    public function create(LikeUserListDTO $likeUserListDTO): ?LikeUserListEntity
    {
        return $this->likeUserListRepo->create($likeUserListDTO->toArray());
    }

    /**
     * Deletes a like user list according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $likeUserList = $this->likeUserListRepo->getById($id);

        if (!$likeUserList) {
            return false;
        }
        return $this->likeUserListRepo->delete($likeUserList);
    }

    /**
     * Restores a like user list according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $likeUserList = $this->likeUserListRepo->getById($id);

        if (!$likeUserList) {
            return false;
        }
        return $this->likeUserListRepo->restore($likeUserList);
    }
}
