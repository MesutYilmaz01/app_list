<?

namespace App\Modules\Dislike\Infrastructure\Repository;

use App\Modules\Dislike\Domain\IRepository\IDislikeUserListRepository;
use App\Modules\Dislike\Domain\Entities\DislikeUserListEntity;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class DislikeUserListRepository extends BaseEloquentRepository implements IDislikeUserListRepository
{
    protected $model = DislikeUserListEntity::class;
    protected array $relationships = [];
}
