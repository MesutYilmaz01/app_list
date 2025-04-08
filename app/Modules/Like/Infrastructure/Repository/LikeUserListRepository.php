<?

namespace App\Modules\Like\Infrastructure\Repository;

use App\Modules\Like\Domain\Entities\LikeUserListEntity;
use App\Modules\Like\Domain\IRepository\ILikeUserListRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class LikeUserListRepository extends BaseEloquentRepository implements ILikeUserListRepository
{
    protected $model = LikeUserListEntity::class;
    protected array $relationships = [];
}
