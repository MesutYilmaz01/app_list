<?

namespace App\Modules\Follow\Infrastructure\Repository;

use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Follow\Domain\IRepository\IFollowRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class FollowRepository extends BaseEloquentRepository implements IFollowRepository
{
    protected $model = FollowEntity::class;
    protected array $relationships = [];
}
