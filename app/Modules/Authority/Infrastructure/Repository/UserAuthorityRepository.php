<?

namespace App\Modules\Authority\Infrastructure\Repository;

use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\IRepository\IUserAuthorityRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserAuthorityRepository extends BaseEloquentRepository implements IUserAuthorityRepository
{
    protected $model = UserAuthorityEntity::class;
}
