<?

namespace App\Modules\Like\Infrastructure\Repository;

use App\Modules\Like\Domain\Entities\LikeCommentEntity;
use App\Modules\Like\Domain\IRepository\ILikeCommentRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class LikeCommentRepository extends BaseEloquentRepository implements ILikeCommentRepository
{
    protected $model = LikeCommentEntity::class;
    protected array $relationships = [];
}
