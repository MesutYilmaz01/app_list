<?

namespace App\Modules\UserList\Infrastructure\Repository;

use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\UserList\Domain\Entities\UserListEntity;

class UserListRepository extends BaseEloquentRepository implements IUserListRepository
{
    protected $model = UserListEntity::class;
}