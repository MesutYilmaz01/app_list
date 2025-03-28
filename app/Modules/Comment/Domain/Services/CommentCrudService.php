<?

namespace App\Modules\Comment\Domain\Services;

use App\Modules\Comment\Domain\DTO\CommentDTO;
use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\IRepository\ICommentRepository;
use App\Modules\Comment\Domain\Enums\StatusType;

class CommentCrudService
{

    public function __construct(
        private ICommentRepository $commentRepo
    ) {}

    /**
     * Gets all comments according to given filter attributes.
     * 
     * @param array $filterParams
     * @return array||null
     */
    public function get(array $filterParams): ?array
    {
        return $this->commentRepo
            ->parseRequest($filterParams)
            ->withFilters($filterParams)
            ->getAll()
            ->toArray();
    }

    /**
     * Gets a comment for given id
     * 
     * @param int $commentId
     * @return CommentEntity||null
     */
    public function show(int $commentId): ?CommentEntity
    {
        $comment = $this->commentRepo->findByAttributes([
            'id' => $commentId,
            'status' => StatusType::ACTIVE->value,
        ]);
        
        if (!$comment) {
            return null;
        }
        
        return $comment;
    }

    /**
     * Creates a comment according to given data
     * 
     * @param CommentDTO $commentDTO
     * @return CommentEntity||null
     */
    public function create(CommentDTO $commentDTO): ?CommentEntity
    {
        return $this->commentRepo->create($commentDTO->toArray());
    }

    /**
     * Updates a comment according to given data
     * 
     * @param int $commentId
     * @param CommentDTO $commentDTO
     * @return CommentEntity||null
     */
    public function update(int $commentId, CommentDTO $commentDTO): ?CommentEntity
    {
        $comment = $this->commentRepo->findByAttributes([
            'id' => $commentId,
            'status' => StatusType::ACTIVE->value,
        ]);

        if (!$comment) {
            return null;
        }

        return $this->commentRepo->update($comment, $commentDTO->toArray());
    }

    /**
     * Deletes a comment according to given id
     * 
     * @param int $commentId
     * @return bool
     */
    public function delete(int $commentId): bool
    {
        $comment = $this->commentRepo->getById($commentId);

        if (!$comment) {
            return false;
        }
        return $this->commentRepo->delete($comment);
    }
}
