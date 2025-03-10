<?

namespace App\Modules\UserList\Infrastructure\Repository;

use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Infrastructure\Filter\UserListFilter;

class UserListRepository extends BaseEloquentRepository implements IUserListRepository
{
    protected $model = UserListEntity::class;
    protected $filter = UserListFilter::class;
    protected array $relationships = [
        'userListsItems'
    ];
}