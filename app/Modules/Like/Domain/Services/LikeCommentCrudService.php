<?

namespace App\Modules\Like\Domain\Services;

use App\Modules\Like\Domain\DTO\LikeCommentDTO;
use App\Modules\Like\Domain\Entities\LikeCommentEntity;
use App\Modules\Like\Domain\IRepository\ILikeCommentRepository;

class LikeCommentCrudService
{
    public function __construct(
        private ILikeCommentRepository $likeCommentRepo
    ) {}
    
    /**
     * Returns like comment according to attributes
     * 
     * @param array $attributes
     * @return LikeCommentEntity||null
     */
    public function findByAttributes(array $attributes): ?LikeCommentEntity
    {
        return $this->likeCommentRepo->findByAttributes($attributes);
    }

    /**
     * Returns only traashed like comment according to attributes
     * 
     * @param array $attributes
     * @return LikeCommentEntity||null
     */
    public function findByAttributesOnlyTrashed(array $attributes): ?LikeCommentEntity
    {
        return $this->likeCommentRepo->onlyTrashed()->findByAttributes($attributes);
    }

    /**
     * Creates a like comment according to given data
     * 
     * @param LikeCommentDTO $likeCommentDTO
     * @return LikeCommentEntity||null
     */
    public function create(LikeCommentDTO $likeCommentDTO): ?LikeCommentEntity
    {
        return $this->likeCommentRepo->create($likeCommentDTO->toArray());
    }

    /**
     * Deletes a like comment according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $likeComment = $this->likeCommentRepo->getById($id);

        if (!$likeComment) {
            return false;
        }
        return $this->likeCommentRepo->delete($likeComment);
    }

    /**
     * Restores a like comment according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $likeComment = $this->likeCommentRepo->getById($id);

        if (!$likeComment) {
            return false;
        }
        return $this->likeCommentRepo->restore($likeComment);
    }
}
