<?

namespace App\Modules\Category\Infrastructure\Repository;

use App\Models\UserList;
use App\Modules\List\Domain\IRepository\IUserListRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserListRepository extends BaseEloquentRepository implements IUserListRepository
{
    protected $model = UserList::class;
}