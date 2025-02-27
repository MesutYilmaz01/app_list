<?

namespace App\Modules\User\Infrastructure\Repository;

use App\Modules\User\Domain\IRepository\IUserRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\User\Domain\Entities\UserEntity;

class UserRepository extends BaseEloquentRepository implements IUserRepository
{
    protected $model = UserEntity::class;
}