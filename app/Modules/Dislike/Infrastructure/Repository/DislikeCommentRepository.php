<?

namespace App\Modules\Dislike\Infrastructure\Repository;

use App\Modules\Dislike\Domain\Entities\DislikeCommentEntity;
use App\Modules\Dislike\Domain\IRepository\IDislikeCommentRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class DislikeCommentRepository extends BaseEloquentRepository implements IDislikeCommentRepository
{
    protected $model = DislikeCommentEntity::class;
    protected array $relationships = [];
}
