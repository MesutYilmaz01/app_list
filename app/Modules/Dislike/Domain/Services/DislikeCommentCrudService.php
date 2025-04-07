<?

namespace App\Modules\Dislike\Domain\Services;

use App\Modules\Dislike\Domain\DTO\DislikeCommentDTO;
use App\Modules\Dislike\Domain\Entities\DislikeCommentEntity;
use App\Modules\Dislike\Domain\IRepository\IDislikeCommentRepository;

class DislikeCommentCrudService
{
    public function __construct(
        private IDislikeCommentRepository $dislikeCommentRepo
    ) {}
    
    /**
     * Returns dislike comment according to attributes
     * 
     * @param array $attributes
     * @return DislikeCommentEntity||null
     */
    public function findByAttributes(array $attributes): ?DislikeCommentEntity
    {
        return $this->dislikeCommentRepo->findByAttributes($attributes);
    }

    /**
     * Returns only traashed dislike comment according to attributes
     * 
     * @param array $attributes
     * @return DislikeCommentEntity||null
     */
    public function findByAttributesOnlyTrashed(array $attributes): ?DislikeCommentEntity
    {
        return $this->dislikeCommentRepo->onlyTrashed()->findByAttributes($attributes);
    }

    /**
     * Creates a dislike comment according to given data
     * 
     * @param DislikeCommentDTO $dislikeCommentDTO
     * @return DislikeCommentEntity||null
     */
    public function create(DislikeCommentDTO $dislikeCommentDTO): ?DislikeCommentEntity
    {
        return $this->dislikeCommentRepo->create($dislikeCommentDTO->toArray());
    }

    /**
     * Deletes a dislike comment according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $dislikeComment = $this->dislikeCommentRepo->getById($id);

        if (!$dislikeComment) {
            return false;
        }
        return $this->dislikeCommentRepo->delete($dislikeComment);
    }

    /**
     * Restores a dislike comment according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $dislikeComment = $this->dislikeCommentRepo->getById($id);

        if (!$dislikeComment) {
            return false;
        }
        return $this->dislikeCommentRepo->restore($dislikeComment);
    }
}
