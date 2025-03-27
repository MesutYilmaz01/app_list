<?

namespace App\Modules\Comment\Infrastructure\Repository;

use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\IRepository\ICommentRepository;
use App\Modules\Comment\Infrastructure\Filter\CommentFilter;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class CommentRepository extends BaseEloquentRepository implements ICommentRepository
{
    protected $model = CommentEntity::class;
    protected $filter = CommentFilter::class;
    protected array $relationships = [
        'userLists',
        'user',
        'parent'
    ];
}
